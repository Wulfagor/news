<?php

namespace app\components;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class Great
{

    public static function cut_text($string, $symbols = 150, $add_point = true)
    {

        $var_check = false;
        $string = strip_tags($string);

        if (!empty($string)) {

            if (strlen($string) <= $symbols)
                return $string;

            $new_string = mb_substr($string, 0, $symbols - 2, 'utf8');
            $var_check = true;
            $add_point = true;
        } else
            $new_string = '';

        while ($var_check) {
            if (substr($new_string, -1) == ' ') {
                $symbols -= 1;
                $new_string = mb_substr($new_string, 0, $symbols, 'utf8') . ($add_point ? '..' : '');
                $var_check = false;
            } else {
                $symbols -= 1;
                if (strlen($new_string) > 1)
                    $new_string = mb_substr($new_string, 0, $symbols, 'utf8');
                else {
                    $new_string = $string;
                    $var_check = false;
                }
            }
        }

        return $new_string;
    }

    public static function processFileModel($model, $attribute, $attribute_temp = NULL)
    {
        $answer = NULL;
        $old_attribute = NULL;

        if ($attribute_temp != NULL) {
            $old_attribute = $model->$attribute_temp;
            if ($old_attribute != NULL)
                $answer = $old_attribute;
        }

        $file = UploadedFile::getInstance($model, $attribute);
        $folder_name = mb_strtolower($model->formName());
        $absolute_dir = Yii::getAlias('@webroot/images/' . $folder_name . '/');
        $relative_dir = Yii::getAlias('/images/' . $folder_name . '/');

        if ($file && $file->tempName) {
            if (FileHelper::createDirectory($absolute_dir)) {
                $fileName = $file->baseName . '.' . $file->extension;
                $file->saveAs($absolute_dir . $fileName);
                $answer = $relative_dir . $fileName;
            }
        } elseif ($old_attribute != NULL && file_exists(Yii::getAlias('@webroot' . $old_attribute)))
            unlink(Yii::getAlias('@webroot' . $old_attribute));

        return $answer;
    }
}