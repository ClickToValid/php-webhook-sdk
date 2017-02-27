<?php

namespace ClickToValid\Model\Factory;

use ClickToValid\Model\File;

class FileFactory
{
    /**
     * @param \stdClass $data
     *
     * @return File
     */
    public static function parseData(\stdClass $data)
    {
        $file = new File();

        if (property_exists($data, 'id')) {
            $file->setId($data->id);
        }

        if (property_exists($data, 'filename')) {
            $file->setFilename($data->filename);
        }

        if (property_exists($data, 'size')) {
            $file->setSize($data->size);
        }

        if (property_exists($data, 'extension')) {
            $file->setExtension($data->extension);
        }

        if (property_exists($data, 'mimetype')) {
            $file->setMimetype($data->mimetype);
        }

        return $file;
    }
}
