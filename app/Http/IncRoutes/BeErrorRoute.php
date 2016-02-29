<?php
/**
 * <============ BEGIN = BACKEND ERRORS ============>
 */
Route::get('/backend/error/{id}', function($id) {
    $data = array('id' => $id);
    switch ($id) {
        case '404':
            $data['info'] = (object) array(
                'label' => 'Not Found',
                'content' => 'Oh, the page you\'r looking for can\'t be found' 
            );
            break;
        case '403':
            $data['info'] = (object) array(
                'label' => 'Forbidden',
                'content' => 'You don\'t have permission to access this page' 
            );
            break;
        default:
            $data['info'] = (object) array(
                'label' => 'Have Error',
                'content' => 'Undefined' 
            );
            break;
    }
    return view('backend.errors.be_error_view', compact('data'));
});
/**
 * <============ END = BACKEND ERRORS ============>
 */