<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-10-16 17:15
 */

namespace common\libs;

use Yii;
use yii\base\InvalidParamException;

class Constants
{

    const YesNo_Yes = 1;
    const YesNo_No = 0;

    public static function getYesNoItems($key = null)
    {
        $items = [
            self::YesNo_Yes => Yii::t('app', 'Yes'),
            self::YesNo_No => Yii::t('app', 'No'),
        ];
        return self::getItems($items, $key);
    }

    public static function getWebsiteStatusItems($key = null)
    {
        $items = [
            self::YesNo_Yes => Yii::t('app', 'Opened'),
            self::YesNo_No => Yii::t('app', 'Closed'),
        ];
        return self::getItems($items, $key);
    }

    const COMMENT_INITIAL = 0;
    const COMMENT_PUBLISH = 1;
    const COMMENT_RUBISSH = 2;

    const SUPERID = [1];
    public static function getCommentStatusItems($key = null)
    {
        $items = [
            self::COMMENT_INITIAL => Yii::t('app', 'Not Audited'),
            self::COMMENT_PUBLISH => Yii::t('app', 'Passed'),
            self::COMMENT_RUBISSH => Yii::t('app', 'Unpassed'),
        ];
        return self::getItems($items, $key);
    }

    const TARGET_BLANK = '_blank';
    const TARGET_SELF = '_self';

    public static function getTargetOpenMethod($key = null)
    {
        $items = [
            self::TARGET_BLANK => Yii::t('app', 'Yes'),
            self::TARGET_SELF => Yii::t('app', 'No'),
        ];
        return self::getItems($items, $key);
    }


    const HTTP_METHOD_ALL = 0;
    const HTTP_METHOD_GET = 1;
    const HTTP_METHOD_POST = 2;

    public static function getHttpMethodItems($key = null)
    {
        $items = [
            self::HTTP_METHOD_ALL => 'all',
            self::HTTP_METHOD_GET => 'get',
            self::HTTP_METHOD_POST => 'post',
        ];
        return self::getItems($items, $key);
    }

    const PUBLISH_YES = 1;
    const PUBLISH_NO = 0;

    public static function getArticleStatus($key = null)
    {
        $items = [
            self::PUBLISH_YES => Yii::t('app', 'Publish'),
            self::PUBLISH_NO => Yii::t('app', 'Draft'),
        ];
        return self::getItems($items, $key);
    }

    const INPUT_INPUT = 1;
    const INPUT_TEXTAREA = 2;
    const INPUT_UEDITOR = 3;
    const INPUT_IMG = 4;

    public static function getInputTypeItems($key = null)
    {
        $items = [
            self::INPUT_INPUT => 'input',
            self::INPUT_TEXTAREA => 'textarea',
            self::INPUT_UEDITOR => 'ueditor',
            self::INPUT_IMG => 'image',
        ];
        return self::getItems($items, $key);
    }

    const ARTICLE_VISIBILITY_PUBLIC = 1;
    const ARTICLE_VISIBILITY_COMMENT = 2;
    const ARTICLE_VISIBILITY_SECRET = 3;
    const ARTICLE_VISIBILITY_LOGIN = 4;

    public static function getArticleVisibility($key = null)
    {
        $items = [
            self::ARTICLE_VISIBILITY_PUBLIC => Yii::t('app', 'Public'),
            self::ARTICLE_VISIBILITY_COMMENT => Yii::t('app', 'Reply'),
            self::ARTICLE_VISIBILITY_SECRET => Yii::t('app', 'Password'),
            self::ARTICLE_VISIBILITY_LOGIN => Yii::t('app', 'Login'),
        ];
        return self::getItems($items, $key);
    }

    const Status_Enable = 1;
    const Status_Disable = 0;

    public static function getStatusItems($key = null)
    {
        $items = [
            self::Status_Enable => Yii::t('app', 'Enable'),
            self::Status_Disable => Yii::t('app', 'Disable'),
        ];
        return self::getItems($items, $key);
    }

    private static function getItems($items, $key = null)
    {
        if ($key !== null) {
            if (key_exists($key, $items)) {
                return $items[$key];
            }
            throw new InvalidParamException( 'Unknown key:' . $key );
        }
        return $items;
    }

    const AD_IMG = 1;
    const AD_VIDEO = 2;
    const AD_TEXT = 3;

    public static function getAdTypeItems($key = null)
    {
        $items = [
            self::AD_IMG => 'image',
            self::AD_VIDEO => 'video',
            self::AD_TEXT => 'text',
        ];
        return self::getItems($items, $key);
    }
    /**
     * 车辆类别
     */
    public static function getCarTypeItems($key = null)
    {
        $items = [
            1 => '品牌',
            2 => '配置',
        ];
        return self::getItems($items, $key);
    }
    /**
     * 车辆管理状态
     */
    public static function getCarStatusItems($key = null)
    {
        $items = [
            0 => '闲置中',
            1 => '使用中',
        ];
        return self::getItems($items, $key);
    }
     /**
     * 车辆管理推荐
     */
    public static function getCarRecommendItems($key = null)
    {
        $items = [
            0 => '无推荐',
            1 => '已推荐',
        ];
        return self::getItems($items, $key);
    }
     /**
     * 车辆管理类型
     */
    public static function getCarTypesItems($key = null)
    {
        $items = [
            1 => '经济型',
            2 => 'MPV',
            3 => '轿车',
            4 => 'SUV',
            5 => '其它',
        ];
        return self::getItems($items, $key);
    }
    /**
     * 车辆管理座位数
     */
    public static function getCarSiteItems($key = null)
    {
        $items = [
            5 => '5',
            7 => '7',
        ];
        return self::getItems($items, $key);
    }
     /**
     * 车辆管理座门数
     */
    public static function getCarDoorsItems($key = null)
    {
        $items = [
            5 => '5',
            4 => '4',
        ];
        return self::getItems($items, $key);
    }
    /**
     * 车辆管理挡位
     */
    public static function getCarPositionItems($key = null)
    {
        $items = [
            0 => '自动档',
            1 => '手动档',
        ];
        return self::getItems($items, $key);
    }
    /**
     * 取车方式
     */
    public static function getExtractionMethodItems($key = null)
    {
        $items = [
            1 => '到店自取',
            2 => '送车上门',
        ];
        return self::getItems($items, $key);
    }
    /**
     * 押金状态
     */
    public static function getDepositStatusItems($key = null)
    {
        $items = [
            1 => '无押金',
            2 => '待退还',
        ];
        return self::getItems($items, $key);
    }
    /**
     * 订单状态
     */
    public static function getOrderStatusItems($key = null)
    {
        $items = [
            1 => '用车中',
            2 => '已完成',
            3 => '已取消',
        ];
        return self::getItems($items, $key);
    }

     /**
     * 报名人员状态
     */
    public static function getBmemberItems($key = null)
    {
        $items = [
            0 => '正常',
            1 => '有意向',
            2 => '无意向',
            3 => '已上车',
        ];
        return self::getItems($items, $key);
    }

}
