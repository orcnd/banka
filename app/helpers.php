<?php
if (!function_exists('collectionToOption')) {
    /**
     * converting collections to array for select options
     * @param collection $data data collection
     * @param string $valueKey key for options value
     * @param string $textKey key for options text
     *
     * @return array
     */
    function collectionToOption($data, $valueKey, $textKey)
    {
        $result = [];
        foreach ($data as $d) {
            $result[$d->$valueKey] = $d->$textKey;
        }
        return $result;
    }
}
