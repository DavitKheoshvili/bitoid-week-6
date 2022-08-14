<?php
namespace Drupal\mymodule\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;

use Symfony\Component\HttpFoundation\Request;
/**
 * Provides route responses for the Example module.
 */
class MyMainController extends ControllerBase {
  public function content() {
    $title = "";
    $location = "";
    $checkbox = "";
    
    $title = \Drupal::request()->request->get('title');
    $location = \Drupal::request()->request->get('location');
    $checkbox = \Drupal::request()->request->get('checkbox');
    
    if($title === null){
      $title = "";
    }
    if($location === null){
      $location = "";
    }
    if($checkbox === null){
      $checkbox = "";
    }elseif($checkbox){
      $checkbox = "Full Time";
    }
    
    
    $node_storage = \Drupal::entityTypeManager()-> getStorage('node');
    $nids = \Drupal::entityQuery('node')
    ->condition('type', 'jobs')
     ->condition('field_job_name', $title, 'CONTAINS')
     ->condition('field_country', $location, 'CONTAINS')
     ->condition('field_job_type', $checkbox, 'CONTAINS')
    ->execute();
    if(count($nids) < 1){
      return [
        // Your theme hook name.
        '#theme' => 'mymodule',
        // Your variables.
        '#jobs' => [],
      ];
    }
    

    function timestampToTimeAgo($timestamp){
      $strTime = array("second", "minute", "hour", "day", "month", "year");
      $length = array("60","60","24","30","12","10");
       $diff     = time()- $timestamp;
       for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
       $diff = $diff / $length[$i];
       }
       $diff = round($diff);
       return $diff . " " . $strTime[$i] . "(s) ago ";
    }
    
    foreach ($nids as $nid) {
      $node = Node::load($nid);
      $fid = $node->field_company_logo->getValue()[0]['target_id'];
      $file = File::load($fid);
      $image_uri = $file->getFileUri();
      $style = ImageStyle::load('thumbnail');
      $uri = $style->buildUri($image_uri);
      $url = $style->buildUrl($image_uri);

      $jobs[$nid] = [
        'test_title' => $title,
        'test_location' => $location,
        'test_checkbox' => $checkbox,
        'nid' => $nid,
        'company_logo' => $url,
        'field_current_date' => timestampToTimeAgo($node->field_current_date->value),
        'field_job_type' => $node->field_job_type->value,
        'field_job_name' => $node->field_job_name->value,
        'field_company_name' => $node->field_company_name->value,
        'field_country' => $node->field_country->value,
      ];
    }
    
    
     return [
       // Your theme hook name.
       '#theme' => 'mymodule',
       // Your variables.
       '#jobs' => $jobs,
     ];
  }

}

