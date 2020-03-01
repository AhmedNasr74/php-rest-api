<?php
$app->post('/up', function ($request, $response) {
    $result = [];
    $files = $request->getUploadedFiles();
    if (!empty($files)):
        $profileImg = $files['profile_img'];
        if ($profileImg->getError() === UPLOAD_ERR_OK):
            $ex = strtolower(@end(explode('/', $profileImg->getClientMediaType())));
            $all = array("jpeg","jpg","png","gif");
            if(in_array($ex , $all )):
                $fileName = uniqid(time() . '-');
                $fileName .= $profileImg->getClientFileName();
                $path = str_replace("'\'" , '/' , $_SERVER["DOCUMENT_ROOT"]) . '/public/img/';
                $profileImg->moveTo($path.$fileName);
                $result['status'] = 'ok';
                $result['message'] = 'Photo Uploaded Successfully';
                // $result['path'] = $path;
            else:
                $result['status'] = 'error';
                $result['message'] = 'File Extention Not Allowed';
                $result['id'] = uniqid(time() . '-');
            endif;
        else:
            $result['status'] = 'error';
            $result['message'] = 'Uploading Error';
        endif;
    else:
        $result['status'] = 'error';
        $result['message'] = 'no uploaded photo';
    endif;
    return $response->withJson($result , 200);
});
