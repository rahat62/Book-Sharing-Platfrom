<?php
use App\Models\Book_user;
// use Image;

class Helper {

	static $googleKey = 'AIzaSyC2Um1RKYtS32dKJn00CmmmhWQPfW6nAGU';

    public static function getYoutubeVideoTitle($video_id)
    {
        $json = self::file_get_content_curl('https://www.googleapis.com/youtube/v3/videos?id='.$video_id.'&key=AIzaSyC2Um1RKYtS32dKJn00CmmmhWQPfW6nAGU&part=snippet');
        $ytdata = json_decode($json);
        if(!empty($ytdata->items)) {
            return $ytdata->items[0]->snippet->title;
        } else {
            return "";
        }
    }
    public static function file_get_content_curl ($url) 
    {
        // Throw Error if the curl function does'nt exist.
        if (!function_exists('curl_init')){ 
            die('CURL is not installed!');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
    public static function getUploadedFileName($mainFile, $imgPath, $reqWidth=0, $reqHeight=0)
    {
        // dd($reqWidth, $reqHeight);
        $fileExtention = $mainFile->extension();
        $fileOriginalName = $mainFile->getClientOriginalName();

        $validExtentions = array('jpeg', 'jpg', 'png', 'gif');
        $path = public_path($imgPath);
        $currentTime = time();
        $fileName = $currentTime.'.'.$fileExtention;
        
        if (in_array($fileExtention, $validExtentions)) {
            $imgDimention = true; 
            // if ($reqWidth > 0 || $reqHeight > 0) {
            //     $imgSizeArr = getimagesize($mainFile);
            //     $imgWidth = $imgSizeArr[0];
            //     $imgHeight = $imgSizeArr[1];
                
            //     if ($reqWidth > 0 && $reqHeight > 0 && ($imgWidth != $reqWidth || $imgHeight != $reqHeight)) {
            //         $imgDimention = false;
            //         $dimentionErrMsg = "Image size must be ".$reqWidth."px * ".$reqHeight."px";
            //     } elseif ($reqWidth > 0 && $imgWidth != $reqWidth) {
            //         $imgDimention = false;
            //         $dimentionErrMsg = "Image width must be ".$reqWidth."px";
            //     } elseif ($reqHeight > 0 && $imgHeight != $reqHeight) {
            //         $imgDimention = false;
            //         $dimentionErrMsg = "Image height must be ".$reqHeight."px";
            //     } 
            //     // else {
            //     //     $imgDimention = false;
            //     //     $dimentionErrMsg = "Image height & Width does not match";
            //     // }
            // } 

            if ($imgDimention) {
                // dd(2);
                $mainFile->move($path, $fileName);
                //create instance
                $img = Image::make($path.'/'.$fileName);
                // dd(1);
                //resize image
                $img->resize($reqWidth, $reqHeight, function ($constraint) {
                    // $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $img->save($path.'/thumb/'.$fileName);
                
                $output['status'] = 1;
                $output['file_name'] = $fileName;
            } else {
                $output['errors'] = $dimentionErrMsg;
                $output['status'] = 0;
            }

        } else {
            $output['errors'] = $fileExtention.' File is not support';
            $output['status'] = 0;
        }
        return $output;

    }

    public static function dateYMD($date){
        $date = date_create($date);
        return $date = date_format($date,"Y-m-d");
    }

    public static function timeHi24($time){    
        $time = date("H:i", strtotime($time));
        return $time;
    }
    public static function timeHis($time){    
        $time = DateTime::createFromFormat('g:i A', $time);
        $time = $time->format('H:i:s');
    }

    public static function timeGia($time){    
        $time = DateTime::createFromFormat('H:i:s', $time);
        $time = $time->format('g:i A');
    }

    public static function bookIdGenerate(){
        $last_book_id = Book_user::valid()->latest()->first();

        if (!empty($last_book_id)) {
            return (int)$last_book_id->book_id + 1;
        }else{
            return date('Ydhm').'1';
        }
	}

    // public function storeImage($request, $imgPath) {
    //     // Get file from request
    //     $file = $request->file('image');
    
    //     // Get filename with extension
    //     $filenameWithExt = $file->getClientOriginalName();
    
    //     // Get file path
    //     $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
    
    //     // Remove unwanted characters
    //     $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
    //     $filename = preg_replace("/\s+/", '-', $filename);
    
    //     // Get the original image extension
    //     $extension = $file->getClientOriginalExtension();
    
    //     // Create unique file name
    //     $fileNameToStore = $filename.'_'.time().'.'.$extension;
    
    //     // Refer image to method resizeImage
    //     $save = $this->resizeImage($file, $fileNameToStore);
    
    //     return true;
    // }
    
    // public function resizeImage($file, $fileNameToStore) {
    //     // Resize image
    //     $resize = Image::make($file)->resize(600, null, function ($constraint) {
    //     $constraint->aspectRatio();
    //     })->encode('jpg');
    
    //     // Create hash value
    //     $hash = md5($resize->__toString());
    
    //     // Prepare qualified image name
    //     $image = $hash."jpg";
    
    //     // Put image to storage
    //     $save = Storage::put("public/images/{$fileNameToStore}", $resize->__toString());
    
    //     if($save) {
    //     return true;
    //     }
    //     return false;
    // }
    
}