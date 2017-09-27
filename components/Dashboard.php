<?php

namespace app\components;

use Yii;
use app\models\custom_user\User;

class Dashboard
{
    private $isGuest = 0;
    public $role = 'User';
    public $items_resolutions = [];
    public $items = [];
    public $answer_resolutions = [];
    public $embedded_items = [];

    function __construct()
    {
        if (Yii::$app->user->isGuest)
            $this->isGuest = 1;
        else
            $this->role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);

        $this->items_resolutions = Yii::$app->components['dashboard']['items_resolutions'];
        $this->items = Yii::$app->components['dashboard']['items'];
    }

    public function getAllItems()
    {
        return $this->items;
    }

    public function getItemsResolutionsByCurrentUser()
    {
        if (is_array($this->role)) {

            foreach ($this->role as $key => $value) {

                if (isset($value->name) && !empty($value->name)) {

                    $child_roles = Yii::$app->authManager->getChildRoles($value->name);
                    if (isset($child_roles) && !empty($child_roles)) {
                        foreach ($child_roles as $key_children => $value_children) {
                            if ($value->name != $value_children->name) {
                                $this->answer_resolutions = array_merge($this->answer_resolutions, $this->items_resolutions[$value_children->name]);
                            }
                        }
                    }

                    if (isset($this->items_resolutions[$value->name])) {
                        $this->answer_resolutions = array_merge($this->answer_resolutions, $this->items_resolutions[$value->name]);
                    }
                }
            }

            return $this->answer_resolutions;
        } else {
            if (array_key_exists($this->role, $this->items_resolutions)) {
                $this->answer_resolutions = $this->items_resolutions[$this->role];
                return $this->answer_resolutions;
            }
        }

        return $this->answer_resolutions;
    }

    public function getDashboardItems()
    {
        if ($this->isGuest)
            return [];
        else {
            if(empty($this->answer_resolutions))
                $this->getItemsResolutionsByCurrentUser();

            $answer = [];

            if (!empty($this->answer_resolutions)) {

                foreach ($this->answer_resolutions as $key_resolution => $value_resolution) {
                    if (isset($this->items[$key_resolution])) {
                        $answer[$key_resolution] = $this->items[$key_resolution];
                    }
                }
            }

            return $answer;
        }
    }

    public function getEmbeddedItemsByUrl($url = NULL)
    {
        $items = [];

        if ($this->isGuest || empty($url))
            return [];
        else {
            if(empty($this->items))
                return [];
            else {

                $this->getEmbeddedItems($this->items, $url);
                $this->getItemsResolutionsByCurrentUser();

                if(empty($this->embedded_items) || empty($this->answer_resolutions))
                    return [];

                foreach($this->embedded_items as $key => $value) {
                    if($this->existsKeyArray($this->answer_resolutions, $key))
                        $items[$key] = $value;
                }
            }
        }

        return $items;
    }

    public function getEmbeddedItems($array = NULL, $value = NULL)
    {
        if(empty($array) || empty($value))
            return false;

        foreach($array as $a){
            if(isset($a['url']) && $a['url'] == $value && $a['items']) {
                $this->embedded_items = array_merge($this->embedded_items, $a['items']);
            } else {
                if (is_array($a)){
                    $this->getEmbeddedItems($a);
                }
            }
        }
    }

    public function existsKeyArray($array = NULL, $key = NULL)
    {
        if(empty($array) || empty($key))
            return false;

        foreach($array as $a){

            if(array_key_exists($key, $a))
                return true;
            else {
                if (is_array($a)){
                    $this->existsKeyArray($a);
                }
            }
        }

        return false;
    }
}