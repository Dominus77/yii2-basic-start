<?php

namespace modules\users\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class AvatarWidget
 * @package modules\users\widgets
 *
 * @property array $imageOptions
 * @property string $email
 * @property-read string $userEmail
 * @property string|int $size
 */
class AvatarWidget extends Widget
{
    public $imageOptions = [
        'class' => 'img-circle',
    ];
    public $email = '';
    public $size = '80';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->email = !empty($this->email) ? $this->email : $this->getUserEmail();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo $this->getGravatar($this->email, $this->size, 'mm', 'g', true, $this->imageOptions);
    }

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param bool $img True to return a complete IMG tag False for just the URL
     * @param array $attr Optional, additional key/value attributes to include in the IMG tag
     * @return string containing either just a URL or a complete image tag
     * @source https://gravatar.com/site/implement/images/php/
     */
    public function getGravatar($email = '', $s = '80', $d = 'mm', $r = 'g', $img = false, $attr = [])
    {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email))) . '?';
        $url .= http_build_query([
            's' => $s,
            'd' => $d,
            'r' => $r,
        ]);
        return $img ? Html::img($url, $attr) : $url;
    }

    /**
     * @return string
     */
    public function getUserEmail()
    {
        /** @var object $user */
        $user = Yii::$app->user->identity;
        return (!Yii::$app->user->isGuest) ? $user->email : $this->email;
    }
}
