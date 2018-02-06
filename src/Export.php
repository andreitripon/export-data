<?php
namespace ExportData;

abstract class Export{
    /**
     * @var array
     */
    protected $headerArgs;
    /**
     * @var string
     */
    protected $fileName = 'draft';

    /**
     * @var array
     */
    protected $data;

    public function __construct($data = null)
    {
        if(!empty($data) and is_array($data)){
            $this->setData($data);
        }
    }

    abstract public function export();

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return Export
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getHeaderArgs()
    {
        return $this->headerArgs;
    }

    /**
     * @param array $headerArgs
     * @return Export
     */
    public function setHeaderArgs($headerArgs)
    {
        $this->headerArgs = $headerArgs;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     * @return Export
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }
}