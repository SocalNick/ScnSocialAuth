<?php

namespace ScnSocialAuth\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    /**
     * Turn off strict options mode
     */
    protected $__strictMode__ = false;

    protected $providers = array(
        'facebook',
        'foursquare',
        'github',
        'google',
        'linkedIn',
        'twitter',
        'yahoo',
        'tumblr',
        'mailru',
        'odnoklassniki',
        'vkontakte',
        'yandex',
        'instagram',
    );

    /**
     * @var string
     */
    protected $userProviderEntityClass = 'ScnSocialAuth\Entity\UserProvider';

    /**
     * @var boolean
     */
    protected $facebookEnabled = false;

    /**
     * @var string
     */
    protected $facebookClientId;

    /**
     * @var string
     */
    protected $facebookSecret;

    /**
     * @var string
     */
    protected $facebookScope;

    /**
     * @var string
     */
    protected $facebookDisplay;

    /**
     * @var boolean
     */
    protected $facebookTrustForwarded;

    /**
     * @var string
     */
    protected $githubEnabled = false;

    /**
     * @var string
     */
    protected $githubClientId;

    /**
     * @var string
     */
    protected $githubSecret;

    /**
     * @var string
     */
    protected $githubScope;

    /**
     * @var boolean
     */
    protected $foursquareEnabled = false;

    /**
     * @var string
     */
    protected $foursquareClientId;

    /**
     * @var string
     */
    protected $foursquareSecret;

    /**
     * @var boolean
     */
    protected $googleEnabled = false;

    /**
     * @var string
     */
    protected $googleClientId;

    /**
     * @var string
     */
    protected $googleSecret;

    /**
     * @var string
     */
    protected $googleScope;

    /**
     * @var string
     */
    protected $googleHd;

    /**
     * @var boolean
     */
    protected $linkedInEnabled = false;

    /**
     * @var string
     */
    protected $linkedInClientId;

    /**
     * @var string
     */
    protected $linkedInSecret;

    /**
     * @var boolean
     */
    protected $twitterEnabled = false;

    /**
     * @var string
     */
    protected $twitterConsumerKey;

    /**
     * @var string
     */
    protected $twitterConsumerSecret;

    /**
     * @var boolean
     */
    protected $yahooEnabled = false;

    /**
     * @var string
     */
    protected $yahooClientId;

    /**
     * @var string
     */
    protected $yahooSecret;

    /**
     * @var boolean
     */
    protected $tumblrEnabled = false;

    /**
     * @var string
     */
    protected $tumblrConsumerKey;

    /**
     * @var string
     */
    protected $tumblrConsumerSecret;

    /**
     * @var boolean
     */
    protected $mailruEnabled = false;

    /**
     * @var string
     */
    protected $mailruClientId;

    /**
     * @var string
     */
    protected $mailruSecret;

    /**
     * @var boolean
     */
    protected $vkontakteEnabled = false;

    /**
     * @var string
     */
    protected $vkontakteAppId;

    /**
     * @var string
     */
    protected $vkontakteSecret;

    /**
     * @var boolean
     */
    protected $yandexEnabled = false;

    /**
     * @var string
     */
    protected $yandexAppId;

    /**
     * @var string
     */
    protected $yandexSecret;

    /**
     * @var boolean
     */
    protected $odnoklassnikiEnabled = false;

    /**
     * @var string
     */
    protected $odnoklassnikiApplicationId;

    /**
     * @var string
     */
    protected $odnoklassnikiKey;

    /**
     * @var string
     */
    protected $odnoklassnikiSecret;

    /**
     * @var boolean
     */
    protected $instagramEnabled = false;

    /**
     * @var string
     */
    protected $instagramClientId;
    /**
     * @var string
     */
    protected $instagramClientSecret;

    /**
     * @var string
     */
    protected $socialLoginOnly = false;

    /**
     * @var boolean
     */
    protected $enableSocialRegistration = true;

    /**
     * get an array of enabled providers
     *
     * @return array
     */
    public function getEnabledProviders()
    {
        $enabledProviders = array();
        foreach ($this->providers as $provider) {
            $method = 'get' . $provider . 'Enabled';
            if ($this->$method()) {
                $enabledProviders[] = $provider;
            }
        }

        return $enabledProviders;
    }

    /**
     * set user provider entity class
     *
     * @param  string        $userProviderEntityClass
     * @return ModuleOptions
     */
    public function setUserProviderEntityClass($userProviderEntityClass)
    {
        $this->userProviderEntityClass = (string) $userProviderEntityClass;

        return $this;
    }

    /**
     * get user provider entity class
     *
     * @return string
     */
    public function getUserProviderEntityClass()
    {
        return $this->userProviderEntityClass;
    }

    /**
     * set facebook enabled
     *
     * @param  boolean       $facebookEnabled
     * @return ModuleOptions
     */
    public function setFacebookEnabled($facebookEnabled)
    {
        $this->facebookEnabled = (boolean) $facebookEnabled;

        return $this;
    }

    /**
     * get facebook enabled
     *
     * @return boolean
     */
    public function getFacebookEnabled()
    {
        return $this->facebookEnabled;
    }

    /**
     * set facebook client id
     *
     * @param  string        $facebookClientId
     * @return ModuleOptions
     */
    public function setFacebookClientId($facebookClientId)
    {
        $this->facebookClientId = (string) $facebookClientId;

        return $this;
    }

    /**
     * get facebook client id
     *
     * @return string
     */
    public function getFacebookClientId()
    {
        return $this->facebookClientId;
    }

    /**
     * set facebook secret
     *
     * @param  string        $facebookSecret
     * @return ModuleOptions
     */
    public function setFacebookSecret($facebookSecret)
    {
        $this->facebookSecret = (string) $facebookSecret;

        return $this;
    }

    /**
     * get facebook secret
     *
     * @return string
     */
    public function getFacebookSecret()
    {
        return $this->facebookSecret;
    }

    /**
     * set facebook scope
     *
     * @param  string        $facebookScope
     * @return ModuleOptions
     */
    public function setFacebookScope($facebookScope)
    {
        $this->facebookScope = (string) $facebookScope;

        return $this;
    }

    /**
     * get facebook scope
     *
     * @return string
     */
    public function getFacebookScope()
    {
        return $this->facebookScope;
    }

    /**
     * set facebook display
     *
     * @param  string        $facebookDisplay
     * @return ModuleOptions
     */
    public function setFacebookDisplay($facebookDisplay)
    {
        $this->facebookDisplay = (string) $facebookDisplay;

        return $this;
    }

    /**
     * get facebook display
     *
     * @return string
     */
    public function getFacebookDisplay()
    {
        return $this->facebookDisplay;
    }

    /**
     * @param boolean $facebookTrustForwarded
     *
     * @return ModuleOptions
     */
    public function setFacebookTrustForwarded($facebookTrustForwarded)
    {
        $this->facebookTrustForwarded = $facebookTrustForwarded;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getFacebookTrustForwarded()
    {
        return $this->facebookTrustForwarded;
    }

    /**
     * set foursquare enabled
     *
     * @param  boolean       $foursquareEnabled
     * @return ModuleOptions
     */
    public function setFoursquareEnabled($foursquareEnabled)
    {
        $this->foursquareEnabled = (boolean) $foursquareEnabled;

        return $this;
    }

    /**
     * get foursquare enabled
     *
     * @return string
     */
    public function getFoursquareEnabled()
    {
        return $this->foursquareEnabled;
    }

    /**
     * set foursquare client id
     *
     * @param  string        $foursquareClientId
     * @return ModuleOptions
     */
    public function setFoursquareClientId($foursquareClientId)
    {
        $this->foursquareClientId = (string) $foursquareClientId;

        return $this;
    }

    /**
     * get foursquare client id
     *
     * @return string
     */
    public function getFoursquareClientId()
    {
        return $this->foursquareClientId;
    }

    /**
     * set foursquare secret
     *
     * @param  string        $foursquareSecret
     * @return ModuleOptions
     */
    public function setFoursquareSecret($foursquareSecret)
    {
        $this->foursquareSecret = (string) $foursquareSecret;

        return $this;
    }

    /**
     * get foursquare secret
     *
     * @return string
     */
    public function getFoursquareSecret()
    {
        return $this->foursquareSecret;
    }

    /**
     * set github enabled
     *
     * @param  boolean       $githubEnabled
     * @return ModuleOptions
     */
    public function setGithubEnabled($githubEnabled)
    {
        $this->githubEnabled = (boolean) $githubEnabled;

        return $this;
    }

    /**
     * get github enabled
     *
     * @return boolean
     */
    public function getGithubEnabled()
    {
        return $this->githubEnabled;
    }

    /**
     * set github client id
     *
     * @param  string        $githubClientId
     * @return ModuleOptions
     */
    public function setGithubClientId($githubClientId)
    {
        $this->githubClientId = (string) $githubClientId;

        return $this;
    }

    /**
     * get github client id
     *
     * @return string
     */
    public function getGithubClientId()
    {
        return $this->githubClientId;
    }

    /**
     * set github secret
     *
     * @param  string        $githubSecret
     * @return ModuleOptions
     */
    public function setGithubSecret($githubSecret)
    {
        $this->githubSecret = (string) $githubSecret;

        return $this;
    }

    /**
     * get github secret
     *
     * @return string
     */
    public function getGithubSecret()
    {
        return $this->githubSecret;
    }

    /**
     * set github scope
     *
     * @param  string        $githubScope
     * @return ModuleOptions
     */
    public function setGithubScope($githubScope)
    {
        $this->githubScope = (string) $githubScope;

        return $this;
    }

    /**
     * get github scope
     *
     * @return string
     */
    public function getGithubScope()
    {
        return $this->githubScope;
    }

    /**
     * set google enabled
     *
     * @param  boolean       $googleEnabled
     * @return ModuleOptions
     */
    public function setGoogleEnabled($googleEnabled)
    {
        $this->googleEnabled = (boolean) $googleEnabled;

        return $this;
    }

    /**
     * get google enabled
     *
     * @return boolean
     */
    public function getGoogleEnabled()
    {
        return $this->googleEnabled;
    }

    /**
     * set google client id
     *
     * @param  string        $googleClientId
     * @return ModuleOptions
     */
    public function setGoogleClientId($googleClientId)
    {
        $this->googleClientId = (string) $googleClientId;

        return $this;
    }

    /**
     * get google client id
     *
     * @return string
     */
    public function getGoogleClientId()
    {
        return $this->googleClientId;
    }

    /**
     * set google secret
     *
     * @param  string        $googleSecret
     * @return ModuleOptions
     */
    public function setGoogleSecret($googleSecret)
    {
        $this->googleSecret = (string) $googleSecret;

        return $this;
    }

    /**
     * get google secret
     *
     * @return string
     */
    public function getGoogleSecret()
    {
        return $this->googleSecret;
    }

    /**
     * set google scope
     *
     * @param  string        $googleScope
     * @return ModuleOptions
     */
    public function setGoogleScope($googleScope)
    {
        $this->googleScope = (string) $googleScope;

        return $this;
    }

    /**
     * get google scope
     *
     * @return string
     */
    public function getGoogleScope()
    {
        return $this->googleScope;
    }

    /**
     * set google Hd
     *
     * @param  string        $googleHd
     * @return ModuleOptions
     */
    public function setGoogleHd($googleHd)
    {
        $this->googleHd = (string) $googleHd;

        return $this;
    }

    /**
     * get google Hd
     *
     * @return string
     */
    public function getGoogleHd()
    {
        return $this->googleHd;
    }

    /**
     * set linkedIn enabled
     *
     * @param  boolean       $linkedInEnabled
     * @return ModuleOptions
     */
    public function setLinkedInEnabled($linkedInEnabled)
    {
        $this->linkedInEnabled = (boolean) $linkedInEnabled;

        return $this;
    }

    /**
     * get linkedIn enabled
     *
     * @return string
     */
    public function getLinkedInEnabled()
    {
        return $this->linkedInEnabled;
    }

    /**
     * set linkedIn client id
     *
     * @param  string        $linkedInClientId
     * @return ModuleOptions
     */
    public function setLinkedInClientId($linkedInClientId)
    {
        $this->linkedInClientId = (string) $linkedInClientId;

        return $this;
    }

    /**
     * get linkedIn client id
     *
     * @return string
     */
    public function getLinkedInClientId()
    {
        return $this->linkedInClientId;
    }

    /**
     * set linkedIn secret
     *
     * @param  string        $linkedInSecret
     * @return ModuleOptions
     */
    public function setLinkedInSecret($linkedInSecret)
    {
        $this->linkedInSecret = (string) $linkedInSecret;

        return $this;
    }

    /**
     * get linkedIn secret
     *
     * @return string
     */
    public function getLinkedInSecret()
    {
        return $this->linkedInSecret;
    }

    /**
     * set twitter enabled
     *
     * @param  boolean       $twitterEnabled
     * @return ModuleOptions
     */
    public function setTwitterEnabled($twitterEnabled)
    {
        $this->twitterEnabled = (boolean) $twitterEnabled;

        return $this;
    }

    /**
     * get twitter enabled
     *
     * @return boolean
     */
    public function getTwitterEnabled()
    {
        return $this->twitterEnabled;
    }

    /**
     * set twitter consumer key
     *
     * @param  string        $twitterConsumerKey
     * @return ModuleOptions
     */
    public function setTwitterConsumerKey($twitterConsumerKey)
    {
        $this->twitterConsumerKey = (string) $twitterConsumerKey;

        return $this;
    }

    /**
     * get twitter consumer key
     *
     * @return string
     */
    public function getTwitterConsumerKey()
    {
        return $this->twitterConsumerKey;
    }

    /**
     * set twitter consumer secret
     *
     * @param  string        $twitterConsumerSecret
     * @return ModuleOptions
     */
    public function setTwitterConsumerSecret($twitterConsumerSecret)
    {
        $this->twitterConsumerSecret = (string) $twitterConsumerSecret;

        return $this;
    }

    /**
     * get twitter consumer secret
     *
     * @return string
     */
    public function getTwitterConsumerSecret()
    {
        return $this->twitterConsumerSecret;
    }

    /**
     * set yahoo enabled
     *
     * @param  boolean       $yahooEnabled
     * @return ModuleOptions
     */
    public function setYahooEnabled($yahooEnabled)
    {
        $this->yahooEnabled = (boolean) $yahooEnabled;

        return $this;
    }

    /**
     * get yahoo enabled
     *
     * @return boolean
     */
    public function getYahooEnabled()
    {
        return $this->yahooEnabled;
    }

    /**
     * set yahoo client id
     *
     * @param  string        $yahooClientId
     * @return ModuleOptions
     */
    public function setYahooClientId($yahooClientId)
    {
        $this->yahooClientId = (string) $yahooClientId;

        return $this;
    }

    /**
     * get yahoo client id
     *
     * @return string
     */
    public function getYahooClientId()
    {
        return $this->yahooClientId;
    }

    /**
     * set yahoo secret
     *
     * @param  string        $yahooSecret
     * @return ModuleOptions
     */
    public function setYahooSecret($yahooSecret)
    {
        $this->yahooSecret = (string) $yahooSecret;

        return $this;
    }

    /**
     * get yahoo secret
     *
     * @return string
     */
    public function getYahooSecret()
    {
        return $this->yahooSecret;
    }

    /**
     * set tumblr enabled
     *
     * @param  boolean       $tumblrEnabled
     * @return ModuleOptions
     */
    public function setTumblrEnabled($tumblrEnabled)
    {
        $this->tumblrEnabled = (boolean) $tumblrEnabled;

        return $this;
    }

    /**
     * get tumblr enabled
     *
     * @return boolean
     */
    public function getTumblrEnabled()
    {
        return $this->tumblrEnabled;
    }

    /**
     * set tumblr consumer key
     *
     * @param  string        $tumblrConsumerKey
     * @return ModuleOptions
     */
    public function setTumblrConsumerKey($tumblrConsumerKey)
    {
        $this->tumblrConsumerKey = (string) $tumblrConsumerKey;

        return $this;
    }

    /**
     * get tumblr consumer key
     *
     * @return string
     */
    public function getTumblrConsumerKey()
    {
        return $this->tumblrConsumerKey;
    }

    /**
     * set tumblr consumer secret
     *
     * @param  string        $tumblrConsumerSecret
     * @return ModuleOptions
     */
    public function setTumblrConsumerSecret($tumblrConsumerSecret)
    {
        $this->tumblrConsumerSecret = (string) $tumblrConsumerSecret;

        return $this;
    }

    /**
     * get tumblr consumer secret
     *
     * @return string
     */
    public function getTumblrConsumerSecret()
    {
        return $this->tumblrConsumerSecret;
    }

    /**
     * set social login only
     *
     * @param  boolean       $socialLoginOnly
     * @return ModuleOptions
     */
    public function setSocialLoginOnly($socialLoginOnly)
    {
        $this->socialLoginOnly = (bool) $socialLoginOnly;

        return $this;
    }

    /**
     * @param string $mailruClientId
     */
    public function setMailruClientId($mailruClientId)
    {
        $this->mailruClientId = (string) $mailruClientId;
    }

    /**
     * @return string
     */
    public function getMailruClientId()
    {
        return $this->mailruClientId;
    }

    /**
     * @param boolean $mailruEnabled
     */
    public function setMailruEnabled($mailruEnabled)
    {
        $this->mailruEnabled = (bool) $mailruEnabled;
    }

    /**
     * @return boolean
     */
    public function getMailruEnabled()
    {
        return $this->mailruEnabled;
    }

    /**
     * @param string $mailruSecret
     */
    public function setMailruSecret($mailruSecret)
    {
        $this->mailruSecret = (string) $mailruSecret;
    }

    /**
     * @return string
     */
    public function getMailruSecret()
    {
        return $this->mailruSecret;
    }

    /**
     * @param string $odnoklassnikiApplicationId
     */
    public function setOdnoklassnikiAppId($odnoklassnikiApplicationId)
    {
        $this->odnoklassnikiApplicationId = (string) $odnoklassnikiApplicationId;
    }

    /**
     * @return string
     */
    public function getOdnoklassnikiAppId()
    {
        return $this->odnoklassnikiApplicationId;
    }

    /**
     * @param boolean $odnoklassnikiEnabled
     */
    public function setOdnoklassnikiEnabled($odnoklassnikiEnabled)
    {
        $this->odnoklassnikiEnabled = (bool) $odnoklassnikiEnabled;
    }

    /**
     * @return boolean
     */
    public function getOdnoklassnikiEnabled()
    {
        return $this->odnoklassnikiEnabled;
    }

    /**
     * @param string $odnoklassnikiKey
     */
    public function setOdnoklassnikiKey($odnoklassnikiKey)
    {
        $this->odnoklassnikiKey = (string) $odnoklassnikiKey;
    }

    /**
     * @return string
     */
    public function getOdnoklassnikiKey()
    {
        return $this->odnoklassnikiKey;
    }

    /**
     * @param string $odnoklassnikiSecret
     */
    public function setOdnoklassnikiSecret($odnoklassnikiSecret)
    {
        $this->odnoklassnikiSecret = (string) $odnoklassnikiSecret;
    }

    /**
     * @return string
     */
    public function getOdnoklassnikiSecret()
    {
        return $this->odnoklassnikiSecret;
    }

    /**
     * @param string $vkontakteAppId
     */
    public function setVkontakteAppId($vkontakteAppId)
    {
        $this->vkontakteAppId = (string) $vkontakteAppId;
    }

    /**
     * @return string
     */
    public function getVkontakteAppId()
    {
        return $this->vkontakteAppId;
    }

    /**
     * @param boolean $vkontakteEnabled
     */
    public function setVkontakteEnabled($vkontakteEnabled)
    {
        $this->vkontakteEnabled = (bool) $vkontakteEnabled;
    }

    /**
     * @return boolean
     */
    public function getVkontakteEnabled()
    {
        return $this->vkontakteEnabled;
    }

    /**
     * @param string $vkontakteSecret
     */
    public function setVkontakteSecret($vkontakteSecret)
    {
        $this->vkontakteSecret = (string) $vkontakteSecret;
    }

    /**
     * @return string
     */
    public function getVkontakteSecret()
    {
        return $this->vkontakteSecret;
    }

    /**
     * @param string $yandexAppId
     */
    public function setYandexAppId($yandexAppId)
    {
        $this->yandexAppId = (string) $yandexAppId;
    }

    /**
     * @return string
     */
    public function getYandexAppId()
    {
        return $this->yandexAppId;
    }

    /**
     * @param boolean $yandexEnabled
     */
    public function setYandexEnabled($yandexEnabled)
    {
        $this->yandexEnabled = (bool) $yandexEnabled;
    }

    /**
     * @return boolean
     */
    public function getYandexEnabled()
    {
        return $this->yandexEnabled;
    }

    /**
     * @param string $yandexSecret
     */
    public function setYandexSecret($yandexSecret)
    {
        $this->yandexSecret = (string) $yandexSecret;
    }

    /**
     * @return string
     */
    public function getYandexSecret()
    {
        return $this->yandexSecret;
    }

    /**
     * @param string $instagramClientId
     */
    public function setInstagramClientId($instagramClientId)
    {
        $this->instagramClientId = (string) $instagramClientId;
    }

    /**
     * @return string
     */
    public function getInstagramClientId()
    {
        return $this->instagramClientId;
    }

    /**
     * @param boolean $instagramEnabled
     */
    public function setInstagramEnabled($instagramEnabled)
    {
        $this->instagramEnabled = (bool) $instagramEnabled;
    }

    /**
     * @return boolean
     */
    public function getInstagramEnabled()
    {
        return $this->instagramEnabled;
    }

    /**
     * @param string $instagramClientSecret
     */
    public function setInstagramClientSecret($instagramClientSecret)
    {
        $this->instagramClientSecret = (string) $instagramClientSecret;
    }

    /**
     * @return string
     */
    public function getinstagramClientSecret()
    {
        return $this->instagramClientSecret;
    }

    /**
     * get social login only
     *
     * @return string
     */
    public function getSocialLoginOnly()
    {
        return $this->socialLoginOnly;
    }

    /**
     * Sets enableSocialRegistration
     *
     * @param bool $enableSocialRegistration
     *
     * @return void
     */
    public function setEnableSocialRegistration($enableSocialRegistration)
    {
        $this->enableSocialRegistration = (bool) $enableSocialRegistration;
    }

    /**
     * Gets enableSocialRegistration
     *
     * @return bool
     */
    public function getEnableSocialRegistration()
    {
        return $this->enableSocialRegistration;
    }
}
