<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const SUCCESS_CODE = 0;
    const ERROR_CODE = 1;
    protected $pageLimit = 10;

    /**
     * @param array $data
     * @return mixed
     * 返回数组
     */
    public function responseData(array $data)
    {
        return response()->json([
            'code' => self::SUCCESS_CODE,
            'message' => '操作成功',
            'data' => $data
        ]);
    }

    /**
     * @param string $message
     * @return mixed
     * 操作成功 无数据返回
     */
    public function responseSuccess($message='操作成功',$data = [])
    {
        return response()->json([
            'code' => self::SUCCESS_CODE,
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseError($message='操作失败')
    {
        return response()->json([
            'code' => self::ERROR_CODE,
            'message' => $message,
            'data' => []
        ]);
    }
}
