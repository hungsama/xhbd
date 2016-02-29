<?php 
namespace App\Libraries;
class SimpleClass
{
    public static function trans_word($str)
    {
        $unicode = array(
          'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
          'd'=>'đ',
          'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
          'i'=>'í|ì|ỉ|ĩ|ị',
          'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
          'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
          'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
          'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
          'D'=>'Đ',
          'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
          'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
          'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
          'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
          'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
          );
        
        foreach($unicode as $nonUnicode=>$uni){
          $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        $str = strtolower(str_replace(' ', '-', $str));
        return $str;
    }

    public static function success_notice($str,$error=false)
    {
        $class = 'success';
        if($error) $class = 'danger';
        $str = "<div class='alert alert-block alert-{$class} fade in'>
        <h4 class='alert-heading text-center'>{$str}</h4>
        </div>";
        return $str;
    }
    
    public static function error_notice($arr_errors)
    {
        $str = "<div class='alert alert-danger'>
          <strong>Whoops</strong> There were some problems with your input. <br><br>
          <ul>";
        foreach ($arr_errors as $er)
            $str .= "<li>".$er.".</li>";
        $str .= "</ul>
        </div>";
        return $str;
    }


    public static function generateRandomString($length = 7) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
