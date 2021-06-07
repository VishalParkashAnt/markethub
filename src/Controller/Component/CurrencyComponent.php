<?php
/**
 * Currency Component
 *
 * Component for Generating Currency in CakePHP 3.x
 *
 * PHP versions 5.4.16
 *
 * @copyright Copyright (c) Arvind K. (http://www.devarticles.in/)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author     Arvind K. (arvind.mailto@gmail.com)
 *
 * @version 3
 *
 * @license     MIT License (http://www.opensource.org/licenses/mit-license.php)
 *
 * Version history
 *
 * 2010-10-25  - Initial version
 * 2010-12-16  - Add Height/Width options to Captcha Image
               - Add the Automatic Deletion of old captcha image files
                 on the server
               - Add Model validation for Captcha
 * 2011-06-09  - Add Random difficulty level Captcha
               - Replace the storing of image files with one time direct
                 output to image tag
               - Add the GD library check
 * 2012-09-01  - Add variations to captcha fonts (size, angle)
               - Add configurable difficulty levels to captcha
               - Created different versions for CakePHP 1.x and 2.x
               - Fixed ob buffering issue
 *             - Add error & messages
 * 2013-04-09  - Add settings parameter to set font, font variations, adjustments
 *             - Update _construct to get controller response (following 2.x approach)
 * 2013-04-12  - Add $theme option to render fixed or random theme
               - Random captcha images are possible. Set “theme”=>”random” in $settings
                 variable of CaptchaComponent.php or in Controller when loading captcha component.
               - Added "Can’t Read? Reload". A working piece of jQuery code is included
                 in view file add.ctp. Be sure to include jquery library, such as https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js to make
                 Reloading of captcha working
 * 2013-09-19  - Add Model.Field name support
               - Updated the controller function to detect the existence of font file
 * 2013-09-25  - Add Image and Simple Math captcha
               - Add support so it works without GD Truetype font support (NOT RECOMMENDED though)
 *             - Refined Default and Random themes for Image Captcha
 * 2014-06-14  - Restructured files
 *             - Refined loading in Controller and Model validation code blocks
               - Fixed header already sent bug
 * 2014-09-06  - Add angel of rotation to the captcha text
 *             - Add Lib > Fonts > (3 font files) and made the captcha selecting random file.
               - Changed some variables to more logical names
 * 2014-09-08  - Add Multiple Captcha Support
 *                A page may have multiple forms and hence multiple captchas. Support multiple Models, Fields.                    Obviously you wont want multiple captchas in a single form.  It however supports it if you                      wanted it! It simply supports multiple captchas on one page. In different forms and in single
                  form as well.
 *             - Add fully configurable from view file
 *             - Fully configurable from view file
 *             - Add Pass Helper settings directly to Helper from Component. Overwrite with
                 custom configurations from view file if found
 * 2015-01-22  - Tested with Cakephp 2.6.0
 * 2015-10-16  - Tested with Cakephp 2.7.5
 * 2015-10-31  - Tested with Cakephp 3.1.1
 *
 */

	namespace App\Controller\Component;

	use Cake\Controller\Component;
	use Cake\Controller\ComponentRegistry;
  

  class CurrencyComponent extends Component	{

    function conversion($itemconvertvalue,$sessionconvertvalue,$itemprice)
    {
      if($itemprice > 0){
	$default_currency_price = $itemprice / $itemconvertvalue;
	$user_currency_price = $default_currency_price * $sessionconvertvalue;
	return round($user_currency_price,2);
      }else{
	return 0;
      }
    }
  }
