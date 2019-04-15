<?php
    /**
     * Created by PhpStorm.
     * User: mitchelwijt
     * Date: 04/03/2019
     * Time: 14:45
     */

    namespace App\Services\Frontend;

    class ExpertiseSphere {
        public $image;
        public $text;
        public $top;
        public $left;
        public $bottom;
        public $right;
        public $width;
        public $height;

        const POSRANGE = 20;



        public function __construct($image, $text, $rangeLeft, $rangeRight, $rangeTop, $rangeBottom) {
            $size = self::getSize();

            $this->image = $image;
            $this->text = $text;
            $this->top = self::getPosition($rangeLeft, $rangeRight, $rangeTop, $rangeBottom)['top'];
            $this->left = self::getPosition($rangeLeft, $rangeRight, $rangeTop, $rangeBottom)['left'];
            $this->bottom = self::getPosition($rangeLeft, $rangeRight, $rangeTop, $rangeBottom)['bottom'];
            $this->right = self::getPosition($rangeLeft, $rangeRight, $rangeTop, $rangeBottom)['right'];
            $this->width = $size['width'];
            $this->height = $size['height'];

        }

        private static function getSize(){
            $sizes = array(['width' => 100 , 'height' => 50], ['width' => 75, 'height' => 37.5], ['width' => 50, 'height' => 25]);
            $size = $sizes[array_rand($sizes)];

            return $size;
        }

        private static function getPosition($rangeLeft, $rangeRight, $rangeTop, $rangeBottom){
            $rangesLeft = [];
            $rangesRight = [];
            $rangesTop = [];
            $rangesBottom = [];

            for($i = 0; $i <= $rangeLeft; $i++){
                array_push($rangesLeft, $i);
            }

            for($i = 0; $i < $rangeRight; $i++){
                array_push($rangesRight, $i);
            }

            for($i = 0; $i < $rangeTop; $i++){
                array_push($rangesTop, $i);
            }

            for($i = 0; $i < $rangeBottom; $i++){
                array_push($rangesBottom, $i);
            }

            $left = $rangesLeft[array_rand($rangesLeft)];
            $right = $rangesRight[array_rand($rangesRight)];
            $top = $rangesTop[array_rand($rangesTop)];
            $bottom = $rangesBottom[array_rand($rangesBottom)];

            return ['left' => $left, 'right' => $right, 'top' => $top, 'bottom' => $bottom];
        }

        public function getTopPos($oldPos = 0){
            return $oldPos + self::POSRANGE;
        }

        public function getBottomPos($oldPos = 0){
            return $oldPos + self::POSRANGE;
        }

        public function getRightPos($oldPos = 0){
            return $oldPos + self::POSRANGE;
        }

        public function getLeftPos($oldPos = 0){
            return $oldPos + self::POSRANGE;
        }
    }