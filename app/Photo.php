<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
	protected $table = 'match_photos';

	protected $fillable = ['match_id', 'filename', 'url'];

	/**
     * Set attributes of the picture
     */
	public function setAttributes($match)
	{
		$this->setBaseFilename($match);
		$this->setDestinationDirectory();
		$this->match_id = $match->id;
		$this->filename = $this->destinationDir . '/' . $this->baseFilename;
		$this->url = env('PHOTO_STORAGE_DIR') . $this->baseFilename;
	}

	/**
     * Rename the picture to correspond with the match id
     */
	public function setBaseFilename($match)
	{
		$this->baseFilename = 'match_photo_' . $match->id . '.' . $this->file->getClientOriginalExtension();
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
		$this->file->move($this->destinationDir, $this->baseFilename);
	}

	/**
     * Remove the file from storage
     */
    public function replace($file, $match)
    {
    	$this->removeFile();
    	$this->delete();
		$this->setFile($file);
        $this->setAttributes($match);
        $this->moveFile();
        unset($this->file, $this->destinationDir, $this->baseFilename);
    }	

	/**
     * Remove the file from storage
     */
	public function removeFile()
	{
		return unlink($this->filename) ? true : false;
	}
}
