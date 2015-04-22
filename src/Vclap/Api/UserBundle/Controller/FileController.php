<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Vclap\Api\UserBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Vclap\Api\UserBundle\Entity\Document;
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\File\File;

class FileController extends Controller
{
    
    /**
     * @Route("/", name="fileoperations")
     */
     public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }
    /**
     * @Route("/upload", name="uploadfile")
     * 
     */
   public function uploadAction(Request $request) {
           $document = new Document();
    $form = $this->createFormBuilder($document)
        ->add('name')
        ->add('file')
        ->getForm();
    $form->handleRequest($request);
    if ($form->isValid()) {
         $document->upload();
            $fil= new File($this->getUploadRootDir().$document->getfname());
            if($fil->getExtension()=='jpg'|$fil->getExtension()=='png'|$fil->getExtension()=='bmp'|$fil->getExtension()=='jpeg'){
            $fileName=substr($document->getfname(), 0 , (strrpos($document->getfname(), "."))).'_thumb'.'.'.$fil->getExtension();
            $thumbnail = new sfThumbnailprivate(150,150);
            $thumbnail->loadFile($fil);
            $thumbnail->save($this->getUploadRootDir().'thumbnailprocessing/'.$fileName, 'image/png');
            $valueArray = array();
            $valueArray['message'] = 'upload sucess';
            $valueArray['filename'] = $document->getfname();
            $valueArray['filethumbname'] = $fileName;
            $returndata = array('data' => json_encode($valueArray));
            }
 else {
     $valueArray = array();
            $valueArray['message'] = 'upload sucess';
            $valueArray['filename'] = $document->getfname();
            $valueArray['filethumbname'] = '';
            $returndata = array('data' => json_encode($valueArray));
 }
            return $this->render('VclapApiUserBundle:Default:index.html.twig',$returndata);
    }

    return $this->render('VclapApiUserBundle:Default:indexform.html.twig', array(
            'form' => $form->createView(),
        ));

    }
    
     protected function getUploadRootDir()
    {
        
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/documents/';
    }
    
    
    
    
}
class sfThumbnailprivate
{
  /**
   * Width of thumbnail in pixels
   */
  protected $thumbWidth;

  /**
   * Height of thumbnail in pixels
   */
  protected $thumbHeight;

  /**
   * Temporary file if the source is not local
   */
  protected $tempFile = null;

  /**
   * Thumbnail constructor
   *
   * @param int (optional) max width of thumbnail
   * @param int (optional) max height of thumbnail
   * @param boolean (optional) if true image scales
   * @param boolean (optional) if true inflate small images
   * @param string (optional) adapter class name
   * @param array (optional) adapter options
   */
  public function __construct($maxWidth = null, $maxHeight = null, $scale = true, $inflate = true, $quality = 75, $adapterClass = null, $adapterOptions = array())
  {
    if (!$adapterClass)
    {
      if (extension_loaded('gd'))
      {
         $this->adapter = new sfGDAdapterprivate($maxWidth, $maxHeight, $scale, $inflate, $quality, $adapterOptions);
             }
      else
      {
       $this->adapter = new sfImageMagickAdapterprivate($maxWidth, $maxHeight, $scale, $inflate, $quality, $adapterOptions);
   
      }
    }
    
  }

  /**
   * Loads an image from a file or URL and creates an internal thumbnail out of it
   *
   * @param string filename (with absolute path) of the image to load. If the filename is a http(s) URL, then an attempt to download the file will be made.
   *
   * @return boolean True if the image was properly loaded
   * @throws Exception If the image cannot be loaded, or if its mime type is not supported
   */
  public function loadFile($image)
  {
    if (eregi('http(s)?://', $image))
    {
      if (class_exists('sfWebBrowser'))
      {
        if (!is_null($this->tempFile)) {
          unlink($this->tempFile);
        }
        $this->tempFile = tempnam('/tmp', 'sfThumbnailPlugin');

        $b = new sfWebBrowser();
        try
        {
          $b->get($image);
          if ($b->getResponseCode() != 200) {
            throw new Exception(sprintf('%s returned error code %s', $image, $b->getResponseCode()));
          }
          file_put_contents($this->tempFile, $b->getResponseText());
          if (!filesize($this->tempFile)) {
            throw new Exception('downloaded file is empty');
          } else {
            $image = $this->tempFile;
          }
        }
        catch (Exception $e)
        {
          throw new Exception("Source image is a URL but it cannot be used because ". $e->getMessage());
        }
      }
      else
      {
        throw new Exception("Source image is a URL but sfWebBrowserPlugin is not installed");
      }
    }
    else
    {
      if (!is_readable($image))
      {
        throw new Exception(sprintf('The file "%s" is not readable.', $image));
      }
    }


    $this->adapter->loadFile($this, $image);
  }

  /**
  * Loads an image from a string (e.g. database) and creates an internal thumbnail out of it
  *
  * @param string the image string (must be a format accepted by imagecreatefromstring())
  * @param string mime type of the image
  *
  * @return boolean True if the image was properly loaded
  * @access public
  * @throws Exception If image mime type is not supported
  */
  public function loadData($image, $mime)
  {
    $this->adapter->loadData($this, $image, $mime);
  }

  /**
   * Saves the thumbnail to the filesystem
   * If no target mime type is specified, the thumbnail is created with the same mime type as the source file.
   *
   * @param string the image thumbnail file destination (with absolute path)
   * @param string The mime-type of the thumbnail (possible values are 'image/jpeg', 'image/png', and 'image/gif')
   *
   * @access public
   * @return void
   */
  public function save($thumbDest, $targetMime = null)
  {
    $this->adapter->save($this, $thumbDest, $targetMime);
  }

  /**
   * Returns the thumbnail as a string
   * If no target mime type is specified, the thumbnail is created with the same mime type as the source file.
   *
   *
   * @param string The mime-type of the thumbnail (possible values are adapter dependent)
   *
   * @access public
   * @return string
   */
  public function toString($targetMime = null)
  {
    return $this->adapter->toString($this, $targetMime);
  }

  public function toResource()
  {
    return $this->adapter->toResource($this);
  }

  public function freeSource()
  {
    if (!is_null($this->tempFile)) {
      unlink($this->tempFile);
    }
    $this->adapter->freeSource();
  }

  public function freeThumb()
  {
    $this->adapter->freeThumb();
  }

  public function freeAll()
  {
    $this->adapter->freeSource();
    $this->adapter->freeThumb();
  }

  /**
   * Returns the width of the thumbnail
   */
  public function getThumbWidth()
  {
    return $this->thumbWidth;
  }

  /**
   * Returns the height of the thumbnail
   */
  public function getThumbHeight()
  {
    return $this->thumbHeight;
  }

  /**
   * Returns the mime type of the source image
   */
  public function getMime()
  {
    return $this->adapter->getSourceMime();
  }

  /**
   * Computes the thumbnail width and height
   * Used by adapter
   */
  public function initThumb($sourceWidth, $sourceHeight, $maxWidth, $maxHeight, $scale, $inflate)
  {
    if ($maxWidth > 0)
    {
      $ratioWidth = $maxWidth / $sourceWidth;
    }
    if ($maxHeight > 0)
    {
      $ratioHeight = $maxHeight / $sourceHeight;
    }

    if ($scale)
    {
      if ($maxWidth && $maxHeight)
      {
        $ratio = ($ratioWidth < $ratioHeight) ? $ratioWidth : $ratioHeight;
      }
      if ($maxWidth xor $maxHeight)
      {
        $ratio = (isset($ratioWidth)) ? $ratioWidth : $ratioHeight;
      }
      if ((!$maxWidth && !$maxHeight) || (!$inflate && $ratio > 1))
      {
        $ratio = 1;
      }

      $this->thumbWidth = floor($ratio * $sourceWidth);
      $this->thumbHeight = ceil($ratio * $sourceHeight);
    }
    else
    {
      if (!isset($ratioWidth) || (!$inflate && $ratioWidth > 1))
      {
        $ratioWidth = 1;
      }
      if (!isset($ratioHeight) || (!$inflate && $ratioHeight > 1))
      {
        $ratioHeight = 1;
      }
      $this->thumbWidth = floor($ratioWidth * $sourceWidth);
      $this->thumbHeight = ceil($ratioHeight * $sourceHeight);
    }
  }

  public function __destruct()
  {
    $this->freeAll();
  }
}
class sfImageMagickAdapterprivate
{

  protected
    $sourceWidth,
    $sourceHeight,
    $sourceMime,
    $maxWidth,
    $maxHeight,
    $scale,
    $inflate,
    $quality,
    $source,
    $magickCommands;

  /**
   * Mime types this adapter supports
   */
  protected $imgTypes = array(
    'application/pdf',
    'application/postscript',
    'application/vnd.palm',
    'application/x-icb',
    'application/x-mif',
    'image/dcx',
    'image/g3fax',
    'image/gif',
    'image/jng',
    'image/jpeg',
    'image/pbm',
    'image/pcd',
    'image/pict',
    'image/pjpeg',
    'image/png',
    'image/ras',
    'image/sgi',
    'image/svg',
    'image/tga',
    'image/tiff',
    'image/vda',
    'image/vnd.wap.wbmp',
    'image/vst',
    'image/x-fits',
    'image/x-ms-bmp',
    'image/x-otb',
    'image/x-palm',
    'image/x-pcx',
    'image/x-pgm',
    'image/x-photoshop',
    'image/x-ppm',
    'image/x-ptiff',
    'image/x-viff',
    'image/x-win-bitmap',
    'image/x-xbitmap',
    'image/x-xv',
    'image/xpm',
    'image/xwd',
    'text/plain',
    'video/mng',
    'video/mpeg',
    'video/mpeg2',
  );

  /**
   * Imagemagick-specific Type to Mime type map
   */
  protected $mimeMap = array(
    'bmp'   => 'image/bmp',
    'bmp2'  => 'image/bmp',
    'bmp3'  => 'image/bmp',
    'cur'   => 'image/x-win-bitmap',
    'dcx'   => 'image/dcx',
    'epdf'  => 'application/pdf',
    'epi'   => 'application/postscript',
    'eps'   => 'application/postscript',
    'eps2'  => 'application/postscript',
    'eps3'  => 'application/postscript',
    'epsf'  => 'application/postscript',
    'epsi'  => 'application/postscript',
    'ept'   => 'application/postscript',
    'ept2'  => 'application/postscript',
    'ept3'  => 'application/postscript',
    'fax'   => 'image/g3fax',
    'fits'  => 'image/x-fits',
    'g3'    => 'image/g3fax',
    'gif'   => 'image/gif',
    'gif87' => 'image/gif',
    'icb'   => 'application/x-icb',
    'ico'   => 'image/x-win-bitmap',
    'icon'  => 'image/x-win-bitmap',
    'jng'   => 'image/jng',
    'jpeg'  => 'image/jpeg',
    'jpg'   => 'image/jpeg',
    'm2v'   => 'video/mpeg2',
    'miff'  => 'application/x-mif',
    'mng'   => 'video/mng',
    'mpeg'  => 'video/mpeg',
    'mpg'   => 'video/mpeg',
    'otb'   => 'image/x-otb',
    'p7'    => 'image/x-xv',
    'palm'  => 'image/x-palm',
    'pbm'   => 'image/pbm',
    'pcd'   => 'image/pcd',
    'pcds'  => 'image/pcd',
    'pcl'   => 'application/pcl',
    'pct'   => 'image/pict',
    'pcx'   => 'image/x-pcx',
    'pdb'   => 'application/vnd.palm',
    'pdf'   => 'application/pdf',
    'pgm'   => 'image/x-pgm',
    'picon' => 'image/xpm',
    'pict'  => 'image/pict',
    'pjpeg' => 'image/pjpeg',
    'png'   => 'image/png',
    'png24' => 'image/png',
    'png32' => 'image/png',
  );

  public function __construct($maxWidth, $maxHeight, $scale, $inflate, $quality, $options)
  {
    $this->magickCommands = array();
    $this->magickCommands['convert'] = isset($options['convert']) ? escapeshellcmd($options['convert']) : 'convert';
    $this->magickCommands['identify'] = isset($options['identify']) ? escapeshellcmd($options['identify']) : 'identify';

    exec($this->magickCommands['convert'], $stdout);
    if (strpos($stdout[0], 'ImageMagick') === false)
    {
      throw new Exception(sprintf("ImageMagick convert command not found"));
    }

    exec($this->magickCommands['identify'], $stdout);
    if (strpos($stdout[0], 'ImageMagick') === false)
    {
      throw new Exception(sprintf("ImageMagick identify command not found"));
    }

    $this->maxWidth = $maxWidth;
    $this->maxHeight = $maxHeight;
    $this->scale = $scale;
    $this->inflate = $inflate;
    $this->quality = $quality;
    $this->options = $options;
  }

  public function toString($thumbnail, $targetMime = null)
  {
    ob_start();
    $this->save($thumbnail, null, $targetMime);

    return ob_get_clean();
  }

  public function toResource()
  {
    throw new Exception('The ImageMagick adapter does not support the toResource method.');
  }

  public function loadFile($thumbnail, $image)
  {
    // try and use getimagesize()
    // on failure, use identify instead
    $imgData = @getimagesize($image);
    if (!$imgData)
    {
      exec($this->magickCommands['identify'].' '.escapeshellarg($image), $stdout, $retval);
      if ($retval === 1)
      {
        throw new Exception('Image could not be identified.');
      }
      else
      {
        // get image data via identify
        list($img, $type, $dimen) = explode(' ', $stdout[0]);
        list($width, $height) = explode('x', $dimen);

        $this->sourceWidth = $width;
        $this->sourceHeight = $height;
        $this->sourceMime = $this->mimeMap[strtolower($type)];
      }
    }
    else
    {
      // use image data from getimagesize()
      $this->sourceWidth = $imgData[0];
      $this->sourceHeight = $imgData[1];
      $this->sourceMime = $imgData['mime'];
    }
    $this->image = $image;

    // open file resource
    $source = fopen($image, 'r');

    $this->source = $source;

    $thumbnail->initThumb($this->sourceWidth, $this->sourceHeight, $this->maxWidth, $this->maxHeight, $this->scale, $this->inflate);

    return true;
  }

  public function loadData($thumbnail, $image, $mime)
  {
    throw new Exception('This function is not yet implemented. Try a different adapter.');
  }

  public function save($thumbnail, $thumbDest, $targetMime = null)
  {
    $command = '';

    $width  = $this->sourceWidth;
    $height = $this->sourceHeight;
    $x = $y = 0;
    switch (@$this->options['method']) 
    {
      case "shave_all":
        $proportion['source'] = $width / $height;
        $proportion['thumb'] = $thumbnail->getThumbWidth() / $thumbnail->getThumbHeight();
        
        if ($proportion['source'] > 1 && $proportion['thumb'] < 1)
        {
          $x = ($width - $height * $proportion['thumb']) / 2;
        }
        else
        {
          if ($proportion['source'] > $proportion['thumb'])
          {
            $x = ($width - $height * $proportion['thumb']) / 2;
          }
          else
          {
            $y = ($height - $width / $proportion['thumb']) / 2;
          }
        }

        $command = sprintf(" -shave %dx%d", $x, $y);
        break;

      case "shave_bottom":
        if ($width > $height)
        {
          $x = ceil(($width - $height) / 2 );
          $width = $height;
        }
        elseif ($height > $width)
        {
          $y = 0;
          $height = $width;
        }

        if (is_null($thumbDest))
        {
          $command = sprintf(
            " -crop %dx%d+%d+%d %s '-' | %s",
            $width, $height,
            $x, $y,
            escapeshellarg($this->image),
            $this->magickCommands['convert']
          );

          $this->image = '-';
        }
        else
        {
          $command = sprintf(
            " -crop %dx%d+%d+%d %s %s && %s",
            $width, $height,
            $x, $y,
            escapeshellarg($this->image), escapeshellarg($thumbDest),
            $this->magickCommands['convert']
          );

          $this->image = $thumbDest;
        }

        break;
      case 'custom':
      	$coords = $this->options['coords'];
      	if (empty($coords)) break;
      	
      	$x = $coords['x1'];
      	$y = $coords['y1'];
      	$width = $coords['x2'] - $coords['x1'];
      	$height = $coords['y2'] - $coords['y1'];
      	
        if (is_null($thumbDest))
        {
          $command = sprintf(
            " -crop %dx%d+%d+%d %s '-' | %s",
            $width, $height,
            $x, $y,
            escapeshellarg($this->image),
            $this->magickCommands['convert']
          );

          $this->image = '-';
        }
        else
        {
          $command = sprintf(
            " -crop %dx%d+%d+%d %s %s && %s",
            $width, $height,
            $x, $y,
            escapeshellarg($this->image), escapeshellarg($thumbDest),
            $this->magickCommands['convert']
          );

          $this->image = $thumbDest;
        }
      	break;
    } // end switch

    $command .= ' -thumbnail ';
    $command .= $thumbnail->getThumbWidth().'x'.$thumbnail->getThumbHeight();

    // absolute sizing
    if (!$this->scale)
    {
      $command .= '!';
    }

    if ($this->quality && $targetMime == 'image/jpeg')
    {
      $command .= ' -quality '.$this->quality.'% ';
    }

    // extract images such as pages from a pdf doc
    $extract = '';
    if (isset($this->options['extract']) && is_int($this->options['extract']))
    {
      if ($this->options['extract'] > 0)
      {
        $this->options['extract']--;
      }
      $extract = '['.escapeshellarg($this->options['extract']).'] ';
    }

    $output = (is_null($thumbDest))?'-':$thumbDest;
    $output = (($mime = array_search($targetMime, $this->mimeMap))?$mime.':':'').$output;

    $cmd = $this->magickCommands['convert'].' '.$command.' '.escapeshellarg($this->image).$extract.' '.escapeshellarg($output);

    (is_null($thumbDest))?passthru($cmd):exec($cmd);
  }

  public function freeSource()
  {
    if (is_resource($this->source))
    {
      fclose($this->source);
    }
  }

  public function freeThumb()
  {
    return true;
  }

  public function getSourceMime()
  {
    return $this->sourceMime;
  }

}
class sfGDAdapterprivate
{

  protected
    $sourceWidth,
    $sourceHeight,
    $sourceMime,
    $maxWidth,
    $maxHeight,
    $scale,
    $inflate,
    $quality,
    $source,
    $thumb;

  /**
   * List of accepted image types based on MIME
   * descriptions that this adapter supports
   */
  protected $imgTypes = array(
    'image/jpeg',
    'image/pjpeg',
    'image/png',
    'image/gif',
  );

  /**
   * Stores function names for each image type
   */
  protected $imgLoaders = array(
    'image/jpeg'  => 'imagecreatefromjpeg',
    'image/pjpeg' => 'imagecreatefromjpeg',
    'image/png'   => 'imagecreatefrompng',
    'image/gif'   => 'imagecreatefromgif',
  );

  /**
   * Stores function names for each image type
   */
  protected $imgCreators = array(
    'image/jpeg'  => 'imagejpeg',
    'image/pjpeg' => 'imagejpeg',
    'image/png'   => 'imagepng',
    'image/gif'   => 'imagegif',
  );

  public function __construct($maxWidth, $maxHeight, $scale, $inflate, $quality, $options)
  {
    if (!extension_loaded('gd'))
    {
      throw new Exception ('GD not enabled. Check your php.ini file.');
    }
    $this->maxWidth = $maxWidth;
    $this->maxHeight = $maxHeight;
    $this->scale = $scale;
    $this->inflate = $inflate;
    $this->quality = $quality;
    $this->options = $options;
  }

  public function loadFile($thumbnail, $image)
  {
    $imgData = @GetImageSize($image);

    if (!$imgData)
    {
      throw new Exception(sprintf('Could not load image %s', $image));
    }

    if (in_array($imgData['mime'], $this->imgTypes))
    {
      $loader = $this->imgLoaders[$imgData['mime']];
      if(!function_exists($loader))
      {
        throw new Exception(sprintf('Function %s not available. Please enable the GD extension.', $loader));
      }

      $this->source = $loader($image);
      $this->sourceWidth = $imgData[0];
      $this->sourceHeight = $imgData[1];
      $this->sourceMime = $imgData['mime'];
      $thumbnail->initThumb($this->sourceWidth, $this->sourceHeight, $this->maxWidth, $this->maxHeight, $this->scale, $this->inflate);

      $this->thumb = imagecreatetruecolor($thumbnail->getThumbWidth(), $thumbnail->getThumbHeight());
      if ($imgData[0] == $this->maxWidth && $imgData[1] == $this->maxHeight)
      {
        $this->thumb = $this->source;
      }
      else
      {
        imagecopyresampled($this->thumb, $this->source, 0, 0, 0, 0, $thumbnail->getThumbWidth(), $thumbnail->getThumbHeight(), $imgData[0], $imgData[1]);
      }

      return true;
    }
    else
    {
      throw new Exception(sprintf('Image MIME type %s not supported', $imgData['mime']));
    }
  }

  public function loadData($thumbnail, $image, $mime)
  {
    if (in_array($mime,$this->imgTypes))
    {
      $this->source = imagecreatefromstring($image);
      $this->sourceWidth = imagesx($this->source);
      $this->sourceHeight = imagesy($this->source);
      $this->sourceMime = $mime;
      $thumbnail->initThumb($this->sourceWidth, $this->sourceHeight, $this->maxWidth, $this->maxHeight, $this->scale, $this->inflate);

      $this->thumb = imagecreatetruecolor($thumbnail->getThumbWidth(), $thumbnail->getThumbHeight());
      if ($this->sourceWidth == $this->maxWidth && $this->sourceHeight == $this->maxHeight)
      {
        $this->thumb = $this->source;
      }
      else
      {
        imagecopyresampled($this->thumb, $this->source, 0, 0, 0, 0, $thumbnail->getThumbWidth(), $thumbnail->getThumbHeight(), $this->sourceWidth, $this->sourceHeight);
      }

      return true;
    }
    else
    {
      throw new Exception(sprintf('Image MIME type %s not supported', $mime));
    }
  }

  public function save($thumbnail, $thumbDest, $targetMime = null)
  {
    if($targetMime !== null)
    {
      $creator = $this->imgCreators[$targetMime];
    }
    else
    {
      $creator = $this->imgCreators[$thumbnail->getMime()];
    }

    if ($creator == 'imagejpeg')
    {
      imagejpeg($this->thumb, $thumbDest, $this->quality);
    }
    else
    {
      $creator($this->thumb, $thumbDest);
    }
  }

  public function toString($thumbnail, $targetMime = null)
  {
    if ($targetMime !== null)
    {
      $creator = $this->imgCreators[$targetMime];
    }
    else
    {
      $creator = $this->imgCreators[$thumbnail->getMime()];
    }

    ob_start();
    $creator($this->thumb);

    return ob_get_clean();
  }

  public function toResource()
  {
    return $this->thumb;
  }

  public function freeSource()
  {
    if (is_resource($this->source))
    {
      imagedestroy($this->source);
    }
  }

  public function freeThumb()
  {
    if (is_resource($this->thumb))
    {
      imagedestroy($this->thumb);
    }
  }

  public function getSourceMime()
  {
    return $this->sourceMime;
  }

}