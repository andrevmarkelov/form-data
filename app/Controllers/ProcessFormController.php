<?php

namespace App\Controllers;

use App\Models\FormData;

class ProcessFormController extends Controller
{
    protected $need_auth = true;

    public function storeFormData()
    {
        $validated_request = $this->validateRequest();

        if ($validated_request === false) {
            header('HTTP/1.0 403 Forbidden');
            echo 'The request data or headers were wrong.';
        }

        $generator = function () use ($validated_request) {
            foreach ($validated_request['form_data'] as $form_datum) {
                $entry = FormData::retrieveByLength($form_datum['length'], FormData::FETCH_ONE);

                /**
                 * If we already have such LENGTH value in database
                 * -> then skip this record
                 */
                if (!is_null($entry) && $form_datum['form_data_id'] !== $entry->id()) {
                    continue;
                }

                if (is_null($entry)) {
                    $form_data = new FormData([
                        'height' => intval($form_datum['height']),
                        'length' => intval($form_datum['length']),
                        'depth' => intval($form_datum['depth']),
                    ], FormData::LOAD_BY_ARRAY);
                } else {
                    $form_data = new FormData(intval($entry->id()), FormData::LOAD_BY_PK);
                    $form_data->height = intval($form_datum['height']);
                    $form_data->length = intval($form_datum['length']);
                    $form_data->depth = intval($form_datum['depth']);
                }

                yield $form_data;
            }
        };

        $results = [];

        /**
         * @var \ItvisionSy\SimpleORM\DataModel $value
         */
        foreach ($generator() as $value) {

            if ($value->isNew()) {
                $value->save();
                $results[] = $value->id();
            } else {
                $value->update();
            }
        }

        header('Content-Type: application/json');
        echo json_encode([
            'result' => 'ok',
            'created_data_ids' => implode(',', $results),
        ]);
        exit;
    }

    public function validateRequest()
    {
        $is_valid = parent::validateRequest();

        if ($is_valid !== false) {
            /**
             * Filter by uniq length in request
             */
            if (!empty($this->request['form_data'])) {
                $uniq_values = [];

                $this->request['form_data'] = array_filter($this->request['form_data'], function ($var) use (&$uniq_values) {
                    if (array_key_exists($var['length'], $uniq_values)) {
                        return false;
                    } else {
                        $uniq_values[$var['length']] = true;
                        return true;
                    }
                });

                /**
                 * Sort request form data by length
                 */
                usort($this->request['form_data'], function($a, $b) {
                    if ($a['length'] === $b['length']) {
                        return 0;
                    }

                    return ($a['length'] < $b['length']) ? -1 : 1;
                });
            }

            return empty($this->request['form_data']) ? false : $this->request;
        }

        return false;
    }
}
