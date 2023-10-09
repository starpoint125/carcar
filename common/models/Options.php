<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace common\models;

use Yii;
use common\libs\Constants;
use common\helpers\FileDependencyHelper;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%options}}".
 *
 * @property integer $id
 * @property integer $type
 * @property string $name
 * @property string $value
 * @property integer $input_type
 * @property string $tips
 * @property integer $autoload
 * @property integer $sort
 */
class Options extends ActiveRecord
{

    const TYPE_SYSTEM = 0;
    const TYPE_CUSTOM = 1;
    const TYPE_BANNER = 2;
    const TYPE_AD = 3;

    const CUSTOM_AUTOLOAD_NO = 0;
    const CUSTOM_AUTOLOAD_YES = 1;

    const CACHE_DEPENDENCY_TYPE_SYSTEM_FILE_NAME = "options_type_system.txt";


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%options}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'input_type', 'autoload', 'sort'], 'integer'],
            [['name', 'input_type', 'autoload'], 'required'],
            [['name'], 'unique'],
            [
                ['name'],
                'match',
                'pattern' => '/^[a-zA-Z][0-9_]*/',
                'message' => Yii::t('app', 'Must begin with alphabet and can only includes alphabet,_,and number')
            ],
            [['value'], 'string'],
            [['value'], 'default', 'value' => ''],
            [['name', 'tips'], 'string', 'max' => 255],
            [['sort'], 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'name' => Yii::t('app', 'Name'),
            'value' => Yii::t('app', 'Value'),
            'input_type' => Yii::t('app', 'Input Type'),
            'tips' => Yii::t('app', 'Tips'),
            'autoload' => Yii::t('app', 'Autoload'),
            'sort' => Yii::t('app', 'Sort'),
        ];
    }

    /**
     * @return array
     */
    public function getNames()
    {
        return array_keys($this->attributeLabels());
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        $object = Yii::createObject([
            'class' => FileDependencyHelper::className(),
            'fileName' => self::CACHE_DEPENDENCY_TYPE_SYSTEM_FILE_NAME,
        ]);
        $object->updateFile();
        parent::afterSave($insert, $changedAttributes);
    }

    public function beforeSave($insert)
    {
        if( !$insert ){
            if( $this->input_type == Constants::INPUT_IMG ) {
                $temp = explode('\\', self::className());
                $modelName = end( $temp );
                $key = "{$modelName}[{$this->id}][value]";
                $upload = UploadedFile::getInstanceByName($key);
                $old = Options::findOne($this->id);
                /* @var $cdn \feehi\cdn\TargetInterface */
                $cdn = Yii::$app->get('cdn');
                if($upload !== null){
                    $uploadPath = Yii::getAlias('@uploads/setting/custom-setting/');
                    if (! FileHelper::createDirectory($uploadPath)) {
                        $this->addError($key, "Create directory failed " . $uploadPath);
                        return false;
                    }
                    $fullName = $uploadPath . date('YmdHis') . '_' . uniqid() . '.' . $upload->getExtension();
                    if (! $upload->saveAs($fullName)) {
                        $this->addError($key, Yii::t('app', 'Upload {attribute} error: ' . $upload->error, ['attribute' => Yii::t('app', 'Picture')]) . ': ' . $fullName);
                        return false;
                    }
                    $this->value = str_replace(Yii::getAlias('@frontend/web'), '', $fullName);
                    $cdn->upload($fullName, $this->value);
                    if( $old !== null ){
                        $file = Yii::getAlias('@frontend/web') . $old->value;
                        if( file_exists($file) && is_file($file) ) unlink($file);
                        if( $cdn->exists($old->value) ) $cdn->delete($old->value);
                    }
                }else{
                    if( $this->value !== '' ){
                        $file = Yii::getAlias('@frontend/web') . $old->value;
                        if( file_exists($file) && is_file($file) ) unlink($file);
                        if( $cdn->exists($old->value) ) $cdn->delete($old->value);
                        $this->value = '';
                    }else {
                        $this->value = $old->value;
                    }
                }
            }
        }
        return parent::beforeSave($insert);
    }
}
