<?php

namespace VoicesTest;

use Exception;

final class UploadedFile  {

	/**
	 *
	 * @var integer
	 */
	const UPLOAD_ERR_OK = 0;

	/**
	 *
	 * @var integer
	 */
	const UPLOAD_ERR_INI_SIZE = 1;

	/**
	 *
	 * @var integer
	 */
	const UPLOAD_ERR_FORM_SIZE = 2;

	/**
	 *
	 * @var integer
	 */
	const UPLOAD_ERR_PARTIAL = 3;

	/**
	 *
	 * @var integer
	 */
	const UPLOAD_ERR_NO_FILE = 4;

	/**
	 *
	 * @var integer
	 */
	const UPLOAD_ERR_NO_TMP_DIR = 6;

	/**
	 *
	 * @var integer
	 */
	const UPLOAD_ERR_CANT_WRITE = 7;

	/**
	 *
	 * @var integer
	 */
	const UPLOAD_ERR_EXTENSION = 8;

	/**
	 * @var string name
	 */
	public string $name;

	/**
	 *
	 * @var string
	 */
	public string $type;
	
	/**
	 *
	 * @var string
	 */
	public string $extension;

	/**
	 *
	 * @var integer
	 */
	public int $size;

	/**
	 *
	 * @var string
	 */
	public string $tmp_name;

	/**
	 *
	 * @var int
	 */
	public int $error;

    public static $file;

	/**
	 *
	 * @param string $name
	 * @param string $type
	 * @param string $extension
	 * @param string $tmp_name
	 * @param string $error
	 * @param int $size
	 */
	protected function __construct ( string $name, string $type, string $extension, string $tmp_name, string $error, int $size ) {
		if ( ! $name ) {
			throw new Exception( "File name not provided" );
		} else if ( ! $type ) {
			throw new Exception( "File type not provided" );
		} else if ( ! $extension ) {
			throw new Exception( "File extension not provided" );
		} else if ( ! $tmp_name ) {
			throw new Exception( "File path not provided" );
		} else if ( ! file_exists( $tmp_name ) ) {
			throw new Exception( "File '{$tmp_name}' does not exist" );
		}

		$this->name = $name;
		$this->type = $type;
		$this->extension = $extension;
		$this->path = $tmp_name;
		$this->size = $size;
		$this->tmp_name = $tmp_name;
		$this->error = $error;
	}

	/**
	 *
	 * @return UploadedFile|NULL
	 */
	public static function get ( string $input_name ):?UploadedFile {
		if (!empty(self::$file)) {
            return self::$file;
		}

        if(isset($_FILES[$input_name])){
            $file = $_FILES[$input_name];
        } else {
            return null;
        }

		if ($file[ 'error' ]) {
			$code = $file[ 'error' ];
			throw new Exception( "Error uploading file '{$file['name']}'. " . self::getErrorMessageFromCode($code));
		}

		$name = $type = $tmp_name = $error = $size = null;
		extract( $file );

		if ( $type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ) {
			$extension = 'docx';
		} else if ( $type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ) {
			$extension = 'xlsx';
		} else {
			$extension = preg_replace( "/^([a-z]+)\//", "", $type );
		}

		self::$file = new UploadedFile( $name, $type, $extension, $tmp_name, $error, $size );

		return self::$file;
	}

	public static function getErrorMessageFromCode(int $code) {
		switch ( $code ) {
			case self::UPLOAD_ERR_OK :
				return 'There is no error, the file uploaded with success.';
				break;

			case self::UPLOAD_ERR_INI_SIZE :
				return 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
				break;

			case self::UPLOAD_ERR_FORM_SIZE :
				return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
				break;

			case self::UPLOAD_ERR_PARTIAL :
				return 'The uploaded file was only partially uploaded.';
				break;

			case self::UPLOAD_ERR_NO_FILE :
				return 'No file was uploaded.';
				break;

			case self::UPLOAD_ERR_NO_TMP_DIR :
				return 'Missing a temporary folder.';
				break;

			case self::UPLOAD_ERR_CANT_WRITE :
				return 'Failed to write file to disk. Introduced in PHP 5.1.0.';
				break;

			case self::UPLOAD_ERR_EXTENSION :
				return 'A PHP extension stopped the file upload.';
				break;

			default :
				throw new Exception("Unknown error code {$code}");
				break;
		}
	}
}