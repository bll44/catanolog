<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
	protected $table = 'match_photos';

	protected $fillable = ['match_id', 'filename', 'url'];

	// Optionally set the file
	public function __construct($file = null)
	{
		if( ! is_null($file)) $this->file = $file;
	}

	/**
     * Set attributes of the picture
     */
	public function setAttributes($match)
	{
		$this->setFileName($match);
		$this->setDestinationDirectory();
		$this->match_id = $match->id;
		$this->url = env('PHOTO_STORAGE_DIR') . $this->filename;
		$this->filename = $this->destinationDir . '/' . $this->setFilename();
	}

	/**
     * Rename the picture to correspond with the match id
     */
	public function setFilename($match)
	{
		$this->baseFileName = 'match_photo_' . $match->id . '.' . $this->file->getClientOriginalExtension();
		return $this->baseFilename;
	}

	/**
     * Set where to move the photo after upload
     */
	public function setDestinationDirectory()
	{
		$this->destinationDir = public_path() . env('PHOTO_STORAGE_DIR');
	}

	/**
     * Set file attribute to original upload file
     */
	public function setFile($file)
	{
		$this->file = $file;
	}

	/**
     * Moves the file after upload
     */
	public function moveFile()
	{
		$this->file->move($this->destinationDir, $this->filename);
	}

	/**
     * Remove the file from storage
     */
	public function removeFile()
	{
		return unlink($this->filename) ? true : false;
	}
}
