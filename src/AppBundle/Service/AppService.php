<?php

namespace AppBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use AppBundle\Entity\Media;

class AppService
{
    private $serviceContainer;

    public function __construct($serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
    }

    public function getCropImage($media)
    {
        $data = array();
        $data = array('ratio' => $media->getRatio(), 'axis' => json_decode($media->getAxis(),true));
        $picture = file_get_contents($media->getParentCrop()->getSourceUrlMethod());
        $url = $media->getParentCrop()->getSourceUrlMethod();

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $picture = curl_exec($ch);
        curl_close($ch);
        //  $data['profileImage']['src'] = $user->getProfileImage()->getParentCrop()->getSourceUrlMethod();

        //  $size = getimagesize($user->getProfileImage()->getParentCrop()->getSourceUrlMethod());
        // base64 encode the binary data, then break it into chunks according to RFC 2045 semantics

        $base64 = base64_encode($picture);
        $data['src'] = 'data:' . $media->getParentCrop()->getContentType() . ';base64,' . $base64;
        return $data;
    }

    public function uploadCropImage($axis, $ratio, $src, $usage)
    {
        $axis = $axis;
        $ratio = $ratio;
        $imageBase = $src;
        $usage = ($usage) ? $usage : 'profile';
        $tmppath = $this->serviceContainer->getParameter('kernel.root_dir') . '/../web/uploads/gallery';
        $tmpFile = $this->serviceContainer->getParameter('kernel.root_dir') . '/../web/uploads/gallery';
        $imageProvider = $this->serviceContainer->get('sonata.media.provider.image');
        $binaryContent = base64_decode(explode(',', $imageBase)[1]);
        if ($info = getimagesizefromstring($binaryContent)) {
            $temporaryFileName = tempnam($tmppath, 'upload_action_') . '.' . explode('/', $info['mime'])[1];
        }
        file_put_contents($temporaryFileName, $binaryContent);
        $mediaManager = $this->serviceContainer->get('sonata.media.manager.media');
        $parentMedia = new Media();
        $parentMedia->setBinaryContent($temporaryFileName);
        $parentMedia->setContext('source');
        $parentMedia->setProviderName('sonata.media.provider.image');
        $mediaManager->save($parentMedia);


        // $src = $this->get('kernel')->getRootDir() . '/../web/' . 'uploads/profilepic/' . $request->get('name');
        $src = $this->serviceContainer->get('kernel')->getRootDir() . '/../web/uploads/media/' . $imageProvider->getReferenceImage($parentMedia);

        $x = $axis['x1'] * $ratio;
        $y = $axis['y1'] * $ratio;
        $width = ($axis['x2'] * $ratio) - $x;
        $height = ($axis['y2'] * $ratio) - $y;
        switch ($parentMedia->getContentType()) {
            case 'image/gif':
                $img_r = imagecreatefromgif($src);
                break;
            case 'image/jpeg':
                $img_r = imagecreatefromjpeg($src);
                break;
            case 'image/png':
                $img_r = imagecreatefrompng($src);
                break;
        }
        $dst_r = ImageCreateTrueColor($width, $height);
        $temp_file = tempnam($tmpFile, 'crop_action_') . '.' . $parentMedia->getExtension();
        imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $width, $height, $width, $height);
        imagejpeg($dst_r, $temp_file, 90);

        $media = new Media();
        $media->setBinaryContent($temp_file);
        $media->setContext($usage); // video related to the user
        $media->setProviderName('sonata.media.provider.image');
        $media->setCropped(true);
        $media->setParentCrop($parentMedia);
        $media->setX($x);
        $media->setY($y);
        $media->setX2($width);
        $media->setY2($height);
        $media->setAxis(json_encode($axis));
        $media->setRatio($ratio);
        $mediaManager->save($media);
        return $media;
    }

    public function getItineraryFormData($formView)
    {
        // return $formView;
        $data = iterator_to_array($formView);
        $result = array();
        foreach ($data as $key => $item) {
            if (isset($item->vars['choices'])) {
                $choices = array_values($item->vars['choices']);
                $array = array_map(function ($obj) use ($item) {
                    if (isset($item->vars['attr']['has_options'])) {
                        //$options = array();
                        return array('label' => $obj->label, 'value' => $obj->value, 'has_options' => $obj->data->getHasOptions());

                    }
                    if (isset($item->vars['attr']['has_class'])) {
                        $options = array();
                        foreach ($obj->data->getOptions() as $option) {
                            $options[] = array('id' => $option->getId(), 'value' => $option->getName());
                        }
                        return array('label' => $obj->label,
                            'value' => $obj->value,
                            'itemClass' => $obj->data->getItemClass()
                        );
                    }
                    if (isset($item->vars['attr']['keep_data'])) {
                        return $obj;
                    }
                    return array('label' => $obj->label, 'value' => $obj->value);
                }
                    , $choices);
                $result[$key]['choices'] = $array;
            }
            if (isset($item->vars['attr']['choice_disabled'])) {
                $result[$key]['choices'] = array();
            }
            if (isset($item->vars['data'])) {
                if (isset($item->vars['attr']['auto_complete'])) {
                    if (is_a($item->vars['data'], PersistentCollection::class) || is_a($item->vars['data'], ArrayCollection::class)) {
                        $data = iterator_to_array($item->vars['data']);
                        // $data = array();
                        $itemsArray = array();
                        foreach ($data as $itemCollection) {
                            $itemsArray[] = array('label' => $itemCollection->getName(), 'value' => $itemCollection->getId());
                        }
                        $result[$key]['data'] = $itemsArray;
                    } elseif (is_object($item->vars['data'])) {
                        $result[$key]['data']['value'] = $item->vars['data']->getId();
                        $result[$key]['data']['label'] = $item->vars['data']->getName();
                    }
                } elseif (isset($item->vars['attr']['croped'])) {
                    if (is_a($item->vars['data'], PersistentCollection::class) || is_a($item->vars['data'], ArrayCollection::class)) {
                        $data = iterator_to_array($item->vars['data']);
                        // $data = array();
                        $itemsArray = array();
                        foreach ($data as $itemCollection) {
                            $itemsArray[] = array('label' => $itemCollection->getName(), 'value' => $itemCollection->getId());
                        }
                        $result[$key]['data'] = $itemsArray;
                    } elseif (is_object($item->vars['data'])) {

                        $result[$key]['data']['id'] = $item->vars['data']->getId();
                        $result[$key]['data']['crop'] = null;
                        if ($item->vars['data']->getParentCrop()) {

                            $result[$key]['data']['crop'] = $this->getCropImage($item->vars['data']);
                        }
                    }

                } elseif (is_a($item->vars['data'], PersistentCollection::class) || is_a($item->vars['data'], ArrayCollection::class)) {
                    $result[$key]['data'] = $this->getArrayData($item->vars['data']);
                } elseif (is_a($item->vars['data'], 'DateTime')) {
                    $result[$key]['data'] = $item->vars['data']->format('H:i');
                } elseif (is_object($item->vars['data'])) {

                    $result[$key]['data'] = $item->vars['data']->getId();
                } else {
                    $result[$key]['data'] = (string)$item->vars['data'];
                }

                /*  if (is_a($item->vars['data'], 'DateTime') && ($key == 'purchaseDate' || $key == 'birthdate')) {
                      $result[$key]['data'] = $item->vars['data']->getTimestamp() * 1000;
                  } elseif (is_object($item->vars['data'])) {
                      $result[$key] = $item->vars['data']->getId();
                  } else {
                      $result[$key]['data'] = $item->vars['data'];
                  }*/

            } else {
                $result[$key]['data'] = null;
            }
            if (isset($item->vars['prototype'])) {
                $result[$key]['prototype'] = $this->getFormData($item->vars['prototype']);
            }
            if (count($item->children)) {
                $result[$key]['children'] = $this->getFormData($item);
            }
        }
        return $result;
    }
    public function getEditItineraryFormData($formView)
    {
        // return $formView;
        $data = iterator_to_array($formView);
        $result = array();
        foreach ($data as $key => $item) {
            if (isset($item->vars['data'])) {
                if (isset($item->vars['attr']['auto_complete'])) {
                    if (is_a($item->vars['data'], PersistentCollection::class) || is_a($item->vars['data'], ArrayCollection::class)) {
                        $data = iterator_to_array($item->vars['data']);
                        $itemsArray = array();
                        foreach ($data as $itemCollection) {
                            $itemsArray[] = array('label' => $itemCollection->getName(), 'value' => $itemCollection->getId());
                        }
                        $result[$key] = $itemsArray;
                    } elseif (is_object($item->vars['data'])) {
                        $result[$key]['value'] = $item->vars['data']->getId();
                        $result[$key]['label'] = $item->vars['data']->getName();
                    }
                } elseif (isset($item->vars['attr']['croped'])) {
                    if (is_a($item->vars['data'], PersistentCollection::class) || is_a($item->vars['data'], ArrayCollection::class)) {
                        $data = iterator_to_array($item->vars['data']);
                        // $data = array();
                        $itemsArray = array();
                        foreach ($data as $itemCollection) {
                            $itemsArray[] = array('label' => $itemCollection->getName(), 'value' => $itemCollection->getId());
                        }
                        $result[$key] = $itemsArray;
                    } elseif (is_object($item->vars['data'])) {

                        $result[$key]['id'] = $item->vars['data']->getId();
                        $result[$key]['crop'] = null;
                        if ($item->vars['data']->getParentCrop()) {

                            $result[$key]['crop'] = $this->getCropImage($item->vars['data']);
                        }
                    }

                } elseif (is_a($item->vars['data'], PersistentCollection::class) || is_a($item->vars['data'], ArrayCollection::class)) {
                    $result[$key] = $this->getArrayData($item->vars['data']);
                } elseif (is_a($item->vars['data'], 'DateTime')) {
                    $result[$key] = $item->vars['data']->format('H:i');
                } elseif (is_object($item->vars['data'])) {

                    $result[$key] = $item->vars['data']->getId();
                } else {
                    $result[$key] = (string)$item->vars['data'];
                }

                /*  if (is_a($item->vars['data'], 'DateTime') && ($key == 'purchaseDate' || $key == 'birthdate')) {
                      $result[$key]['data'] = $item->vars['data']->getTimestamp() * 1000;
                  } elseif (is_object($item->vars['data'])) {
                      $result[$key] = $item->vars['data']->getId();
                  } else {
                      $result[$key]['data'] = $item->vars['data'];
                  }*/

            } else {
                $result[$key] = null;
            }

        }
        return $result;
    }

    //get form data
    public function getFormData($formView)
    {
        //dump($formView);die();
        //return $formView;
        $data = iterator_to_array($formView);
        $result = array();
        foreach ($data as $key => $item) {
            //    $result[$key]['label'] = $item->vars['name'];
            if (isset($item->vars['label'])) {
                //==  $result[$key]['label'] = $item->vars['label'];
            }
            if (isset($item->vars['block_prefixes'])) {
                // $result[$key]['type'] = $item->vars['block_prefixes'][1];
            }


            if (isset($item->vars['choices'])) {


                $choices = array_values($item->vars['choices']);
                $array = array_map(function ($obj) use ($item) {
                    if (isset($item->vars['attr']['has_options'])) {
                        $options = array();
                        foreach ($obj->data->getOptions() as $option) {
                            $options[] = array('id' => $option->getId(), 'value' => $option->getName());
                        }
                        return array('label' => $obj->label,
                            'value' => $obj->value,
                            'itemClass' => $obj->data->getOptions()
                        );
                    }
                    if (isset($item->vars['attr']['has_class'])) {
                        $options = array();
                        foreach ($obj->data->getOptions() as $option) {
                            $options[] = array('id' => $option->getId(), 'value' => $option->getName());
                        }
                        return array('label' => $obj->label,
                            'value' => $obj->value,
                            'itemClass' => $obj->data->getItemClass()
                        );
                    }
                    if (isset($item->vars['attr']['keep_data'])) {
                        return $obj;
                    }
                    return array('label' => $obj->label, 'value' => $obj->value);
                }
                    , $choices);
                $result[$key]['choices'] = $array;
            }
            if (isset($item->vars['attr']['choice_disabled'])) {
                $result[$key]['choices'] = array();
            }
            if (isset($item->vars['data'])) {
                if (is_a($item->vars['data'], 'DateTime') && ($key == 'purchaseDate' || $key == 'birthdate')) {
                    $result[$key]['data'] = $item->vars['data']->getTimestamp() * 1000;
                } else {
                    $result[$key]['data'] = $item->vars['data'];
                }

            } else {
                $result[$key]['data'] = null;
            }
            if (isset($item->vars['prototype'])) {
                $result[$key]['prototype'] = $this->getFormData($item->vars['prototype']);
            }
            if (count($item->children)) {
                $result[$key]['children'] = $this->getFormData($item);
            }
        }
        return $result;
    }

    public function getFormDataList($formView)
    {
        $data = iterator_to_array($formView);
        $result = array();
        foreach ($data as $key => $item) {

            if (isset($item->vars['block_prefixes'])) {
                $result[$key]['type'] = $item->vars['block_prefixes'][1];
            }
            if (isset($item->vars['choices'])) {
                $choices = array_values($item->vars['choices']);
                $array = array_map(function ($obj) use ($item) {
                    if (isset($item->vars['attr']['has_options'])) {
                        $options = array();
                        foreach ($obj->data->getOptions() as $option) {
                            $options[] = array('id' => $option->getId(), 'value' => $option->getName());
                        }
                        return array('label' => $obj->label,
                            'value' => $obj->value,
                            'has_options' => $obj->data->getHasOptions(),
                            'children' => $options
                        );
                    }
                    if (isset($item->vars['attr']['keep_data'])) {
                        return $obj;
                    }
                    return array('label' => $obj->label, 'value' => $obj->value);
                }
                    , $choices);
                $result[$key]['choices'] = $array;
            }
            if (isset($item->vars['attr']['choice_disabled'])) {
                $result[$key]['choices'] = array();
            }
            if (isset($item->vars['data'])) {
                $result[$key]['data'] = $item->vars['data'];


                if (is_a($item->vars['data'], PersistentCollection::class)) {
                    //     dump($item->vars['data']);die('a');
                    $result[$key]['data'] = $this->getArrayData($item->vars['data']);
                } elseif (is_a($item->vars['data'], 'DateTime')) {
                    $result[$key]['data'] = $item->vars['data']->format('d-m-Y');
                } elseif (is_object($item->vars['data'])) {

                    $result[$key]['data'] = $item->vars['data']->getId();
                } else {
                    $result[$key]['data'] = $item->vars['data'];
                }
            }
            if (isset($item->vars['prototype'])) {
                $result[$key]['prototype'] = $this->getFormDataList($item->vars['prototype']);
            }
            if (count($item->children)) {
                $result[$key]['children'] = $this->getFormDataList($item);
            }
        }
        return $result;
    }

    public function getProfileFormData($formView)
    {
        $data = iterator_to_array($formView);
        $result = array();
        foreach ($data as $key => $item) {
          //  dump($key);die();

            if (isset($item->vars['choices'])) {


                $choices = array_values($item->vars['choices']);
                $array = array_map(function ($obj) use ($item) {
                    if (isset($item->vars['attr']['has_options'])) {
                        $options = array();
                        foreach ($obj->data->getOptions() as $option) {
                            $options[] = array('id' => $option->getId(), 'value' => $option->getName());
                        }
                        return array('label' => $obj->label,
                            'value' => $obj->value,
                            'has_options' => $obj->data->getHasOptions(),
                            'children' => $options
                        );
                    }
                    if (isset($item->vars['attr']['keep_data'])) {
                        return $obj;
                    }
                    return array('label' => $obj->label, 'value' => $obj->value);
                }
                    , $choices);
                $result[$key]['choices'] = $array;
            }
            if (isset($item->vars['attr']['choice_disabled'])) {
                $result[$key]['choices'] = array();
            }

            if (isset($item->vars['data'])) {
                if (is_a($item->vars['data'], 'DateTime') && ($key == 'purchaseDate' || $key == 'birthdate' || $key == 'coverageDate')) {
                    $result[$key]['data'] = $item->vars['data']->getTimestamp() * 1000;
                } else {
                    $result[$key]['data'] = $item->vars['data'];

                    if (is_a($item->vars['data'], PersistentCollection::class)) {
                        $data = iterator_to_array($item->vars['data']);
                        $resultData = array();

                        foreach ($data as $keyData => $itemData) {
                            if (isset($data[0]) && is_a($data[0], \AppBundle\Entity\city::class)) {
                                $dataItem = array();
                                $dataItem['value'] = $itemData->getId();
                                $dataItem['label'] = $itemData->getName();
                                $resultData[] = $dataItem;

                                continue;
                            }
                            if (isset($data[0]) && is_a($data[0], \UserBundle\Entity\bloodType::class)) {
                                $dataItem = array();
                                $dataItem['value'] = $itemData->getId();
                                $dataItem['label'] = $itemData->getName();
                                $resultData[] = $dataItem;
                                continue;
                            }
                            if (isset($data[0]) && is_a($data[0], \AppBundle\Entity\Language::class)) {
                                $dataItem = array();
                                $dataItem['value'] = $itemData->getId();
                                $dataItem['label'] = $itemData->getName();
                                $resultData[] = $dataItem;

                                continue;
                            }

                            if (isset($data[0]) && is_a($data[0], \UserBundle\Entity\gender::class)) {
                                $dataItem = array();
                                $dataItem['value'] = $itemData->getId();
                                $dataItem['label'] = $itemData->getName();
                                $resultData[] = $dataItem;
                                continue;
                            }

                            if (isset($data[0]) && is_a($data[0], \UserBundle\Entity\phoneNumber::class)) {
                                $dataItem = array();
                                $dataItem['phoneNumber'] = $itemData->getPhoneNumber();
                                $dataItem['validated'] = $itemData->getValidated();
                                $resultData[] = $dataItem;
                                continue;
                            }
                            $resultData[] = $itemData;
                        }

                        $result[$key]['data'] = $resultData;
                    } elseif (is_a($item->vars['data'], \AppBundle\Entity\zone::class)) {
                        $dataItem['value'] = $item->vars['data']->getId();
                        $dataItem['label'] = $item->vars['data']->getZoneName();
                        $resultData = $dataItem;
                        $result[$key]['data'] = $resultData;
                    } elseif (is_a($item->vars['data'], \UserBundle\Entity\phoneNumber::class)) {
                        $dataItem['value'] = (string)$item->vars['data']->getId();
                        $dataItem['label'] = (string)$item->vars['data']->getPhoneNumber();
                        $resultData = $dataItem;
                        $result[$key]['data'] = $resultData;
                    } elseif (is_a($item->vars['data'], \UserBundle\Entity\bloodType::class)) {
                        $dataItem['value'] = $item->vars['data']->getId();
                        $dataItem['label'] = $item->vars['data']->getName();
                        $resultData = $dataItem;
                        $result[$key]['data'] = $resultData;
                    } elseif (isset($data[0]) && is_a($data[0], \UserBundle\Entity\gender::class)) {
                        $dataItem['value'] = $item->getId();
                        $dataItem['label'] = $item->getName();
                        $resultData = $dataItem;
                        $result[$key]['data'] = $resultData;
                    } elseif ($item->vars['data'] && is_a($item->vars['data'], \AppBundle\Entity\city::class)) {
                        $dataItem = array();
                        $dataItem['id'] = $item->vars['data']->getId();
                        $dataItem['name'] = $item->vars['data']->getName();
                        $resultData = $dataItem;
                        $result[$key]['data'] = $resultData;
                    } elseif ($item->vars['data'] && is_a($item->vars['data'], \AppBundle\Entity\TypeOfId::class)) {
                        $dataItem['value'] = $item->vars['data']->getId();
                        $dataItem['label'] = $item->vars['data']->getName();
                        $resultData = $dataItem;
                        $result[$key]['data'] = $resultData;
                    }elseif ($item->vars['data'] && is_a($item->vars['data'], \AppBundle\Entity\Media::class)){
                        $dataItem = array();
                        $dataItem['id'] = $item->vars['data']->getId();
                        $dataItem['url'] = $item->vars['data']->getUrlMethod();
                        $result[$key]['data'] = $dataItem;
                    }elseif ($key == 'gender') {
                        $dataItem['value'] = $item->vars['data']->getId();
                        $dataItem['label'] = $item->vars['data']->getName();
                        $resultData = $dataItem;
                        $result[$key]['data'] = $resultData;
                    } else {
                        $result[$key]['data'] = $item->vars['data'];
                    }
                }
            } else {
                $result[$key]['data'] = null;
            }
            if (isset($item->vars['prototype'])) {
                $result[$key]['prototype'] = $this->getFormData($item->vars['prototype']);
            }
            if (count($item->children)) {
                $result[$key]['children'] = $this->getFormData($item);
            }
        }
        return $result;
    }

    public function getEditFormData($formView)
    {
        $data = iterator_to_array($formView);
        $result = array();
        foreach ($data as $key => $item) {
            if (isset($item->vars['data'])) {
                if (is_a($item->vars['data'], PersistentCollection::class)) {
                    $result[$key] = $this->getArrayData($item->vars['data']);
                } elseif (is_a($item->vars['data'], 'DateTime')) {
                    $result[$key] = $item->vars['data']->format('H:i');
                } elseif (is_object($item->vars['data'])) {
                    $result[$key] = $item->vars['data']->getId();
                } else {
                    $result[$key] = (string)$item->vars['data'];
                }
                if ($key == 'cuisine') {
                    //$result[$key] = get_class($item->vars['data']);
                }
            }
        }
        return $result;
    }

    private function getArrayData($data)
    {
        $data = iterator_to_array($data);
        $result = array();

        foreach ($data as $key => $item) {
            if (isset($data[0]) && is_a($data[0], \AppBundle\Entity\WorkingHours::class)) {
                $dataItem['id'] = $item->getId();
                $dataItem['day'] = $item->getDay();
                $dataItem['startFrom'] = ($item->getStartFrom())? $item->getStartFrom()->format('H:i'):null;
                $dataItem['endTo'] = ($item->getEndTo())? $item->getEndTo()->format('H:i'): null;
                $dataItem['isClosed'] = $item->getIsClosed();
                $dataItem['fullDayName'] = $item->getFullDayName();
                $result[] = $dataItem;
                continue;
            }
            if (isset($data[0]) && is_a($data[0], \AppBundle\Entity\Media::class)) {
                $dataItem['id'] = $item->getId();
                $dataItem['url'] = $item->getUrlMethod();
                $result[] = $dataItem;
                continue;
            }
            if (isset($data[0]) && is_a($data[0], \AppBundle\Entity\spokenLanguage::class)) {
                //   $dataItem['id'] = (string) $item->getId();

                $result[] = (string)$item->getId();
                continue;
            }
            if (isset($data[0]) && is_a($data[0], \UserBundle\Entity\phoneNumber::class)) {
                $dataItem['id'] = (string)$item->getId();
                $dataItem['phoneNumber'] = (string)$item->getPhoneNumber();
                $result[] = $dataItem;
                continue;
            }
            $result[] = (string)$item->getId();
        }
        return $result;
    }
    public function getBasePath()
    {
        $basePath = $this->serviceContainer->getParameter('kernel.root_dir') . '/../web/uploads/gallery';
        return $basePath;
    }

}
