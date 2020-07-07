<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property int parent_id
 * @property string $body
 * @property string $path
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 *
 **/
class Comment extends Model
{
    const STATUS_DELETE = -1;
    const STATUS_NEW = 1;
    const PATCH_SEPARATOR = '.';

    protected $primaryKey = 'id';
    private static $_cacheSkip = [];
    protected $fillable = [
        'id',
        'post_id',
        'user_id',
        'parent_id',
        'path',
        'status',
        'body',
        'created_at',
        'updated_at',
    ];

    public static function getTree($post_id)
    {
        $categories = self::where(compact('post_id'))->get();

        return self::sortTree($categories);

    }


    public static function addNew($data)
    {

        $data['path'] = self::getNextPatch($data['post_id'], !empty($data['parent_id']) ? $data['parent_id'] : 0);
        $data['status'] = self::STATUS_NEW;

        return self::create($data);
    }

    private static function getNextPatch($post_id, $parent_id = null)
    {
        $pathPrefix = '';
        if ($parent_id) {
            $lastChild = self::where(compact('parent_id', 'post_id'))->orderBy('created_at', 'DESC')->first();
            $parent = self::find($parent_id);
            if (!$lastChild) {
                return $parent['path'] . self::PATCH_SEPARATOR . 1;
            }
            $pathPrefix = $parent['path'];
        } else {
            $lastChild = self::where(compact('post_id'))->whereNull('parent_id')->orderBy('created_at', 'DESC')->first();
            if (!$lastChild) return 1;

            return ($lastChild['path'] + 1);
        }

        $pathArray = explode(self::PATCH_SEPARATOR, $lastChild['path']);
        return $pathPrefix . self::PATCH_SEPARATOR . (end($pathArray) + 1);

    }

    public static function sortTree(&$categories, $parent = null)
    {
        $result = [];
        foreach ($categories as $key => $cat){

            if($parent == null && !in_array($key, self::$_cacheSkip) ){
                $temp = $cat;
                unset($categories[$key]);
                $temp["children"] = self::sortTree($categories, $cat['path']);
                $result[$cat['path']] = $temp;
            } elseif($parent == substr($cat['path'], 0, strrpos($cat['path'], '.'))) {
                    $temp = $cat;
                    unset($categories[$key]);
                    self::$_cacheSkip[] = $key;
                    $temp["children"] = self::sortTree($categories, $cat['path']);
                    $result[$cat['path']] = $temp;
            }
        }
    return $result;
    }
}
