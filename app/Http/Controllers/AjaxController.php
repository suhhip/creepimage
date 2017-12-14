<?php
namespace App\Http\Controllers;

use App\BaseImage;
use App\CreepImage;
use App\DataEncrytion;
use App\DeCreeptor;
use App\EnCreeptor;
use App\Exception;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
	public function imageInfo(Request $request)
	{
		$validatedData = $this->validate($request, [
			'image' => 'required|image|Mimes:jpg,jpeg,png|max:2000kb',
		]);

		$imageFile = $request->file('image')->getPathName();

		$image = new BaseImage();
		$image->loadFile($imageFile);

		$availablePixels   = $image->getWidth() * $image->getHeight() - CreepImage::PIXELS_FOR_SIZE;
		$availableBytes    = floor($availablePixels / 3);

		$systemMaxLength = CreepImage::getSystemMaxSize();
		if ($availableBytes > $systemMaxLength) {
			$availableBytes = $systemMaxLength;
		}

		$maxLength = DataEncrytion::calculateMaxLength($availableBytes);

		return response()->json([
			'success'      => true,
			'max_length'   => $maxLength,
		]);
	}

	public function encreeptionMethod(Request $request)
	{
		$this->validate($request, [
			'image'     => 'required|image|Mimes:jpg,jpeg,png|max:2000kb',
			'message'   => 'required|string',
		]);

		$imageFile   = $request->file('image')->getPathName();
		$password    = $request->get('password');
		$message	     = $request->get('message');

		$encryptor = new DataEncrytion();
		$encryptor->setRawData($message);
		$data = $encryptor->encrypt($password);

		try {
			$image = new BaseImage();
			$image->loadFile($imageFile);

			$enCreeptor = new EnCreeptor();
			$enCreeptor->loadImage($image);

			if (!$enCreeptor->loadData($data)) {
				throw new \Exception('The received data is too large for this image');
			}

			$enCreeptor->run();
		}
		catch (\Exception $e) {
			return response()->json([
				'success'   => false,
				'message'   => $e->getMessage(),
			]);
		}

		ob_start();
			imagepng($image->getImage());
		$outputBuffer = ob_get_clean();

		return response()->json([
			'success'	=> true,
			'image'     => base64_encode($outputBuffer)
		]);

		return;
	}

	public function decreeptionMethod(Request $request)
	{
		$validatedData = $this->validate($request, [
			'image' => 'required|image|Mimes:png|max:2000kb',
		]);

		$imageFile   = $request->file('image')->getPathName();
		$password    = $request->get('password');

		try {
			$image = new BaseImage();
			if (!$image->loadFile($imageFile)) {
				throw new \Exception('Invalid image file');
			}

			$deCreeptor = new DeCreeptor();
			$deCreeptor->loadImage($image);
			$data = $deCreeptor->run();

			$encryptor = new DataEncrytion();
			$encryptor->setEncryptedData($data);
			$data = $encryptor->decrypt($password);

			if ($data === false) {
				throw new \Exception('Invalid password');
			}
		}
		catch (\Exception $e) {
			return response()->json([
				'success'   => false,
				'message'   => $e->getMessage(),
			]);
		}

		return response()->json([
			'success'   => true,
			'data'      => $data,
		]);
	}
}
