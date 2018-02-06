<?php
namespace ExportData\Export;
use ExportData\Export;

class CSV extends Export{
    /**
     * @var array
     */
    protected $headerRow;

    /**
     * @var string
     */
    protected $delimiter = ',';
    /**
     * @var string
     */
    protected $enclosure = '"';

    /**
     * @var string
     */
    protected $rows = '';

    public function export()
    {
        //set header file
        $this->setHeaderArgs(
            array(
                "Content-type: text/csv",
                "Content-Disposition: attachment; filename=".$this->getFileName().".csv",
                "Pragma: no-cache",
                "Expires: 0"
            )
        );

        $document = $this->createDocument(
            $this->getHeaderArgs()
        );

        //Set header row
        if(!empty($this->getHeaderRow())){
            $document->addRow($this->createRow($this->getHeaderRow()));
        }

        //set content
        if(!empty($this->getData()) and is_array($this->getData())){
            foreach ($this->getData() as $row){
                $document->addRow($this->createRow($row));
            }
        }

        $document->printDocument();
    }

    /**
     * Print the csv file
     */
    protected function printDocument(){
        echo $this->getRows();

        exit;
    }

    /**
     * @param array $headerArgs
     * @return CSV
     */
    protected function createDocument(array $headerArgs){
        foreach ($headerArgs as $headerArg) {
            header($headerArg);
        }

        return $this;
    }

    /**
     * @param array|string $value
     * @return string
     */
    protected function createRow($value){
        if(is_array($value)){
            $row = implode(",", array_map(array($this, 'fieldFilter'), $value));
        }else{
            $row = $this->fieldFilter($value);
        }

        $row .= "\r\n";

        return $row;
    }

    /**
     * @param mixed $field
     * @return mixed
     */
    protected function fieldFilter($field){
        $delimiter_esc = preg_quote($this->getDelimiter(), '/');
        $enclosure_esc = preg_quote($this->getEnclosure(), '/');

        if ($field === null) {
            $field = 'NULL';
        }

        if ($field === false) {
            $field = 0;
        }

        if (preg_match( "/(?:${delimiter_esc}|${enclosure_esc}|\s)/", $field ) ) {
            $field = str_replace($this->getEnclosure(), $this->getEnclosure() . $this->getEnclosure(), $field);
            $field = $this->getEnclosure().$field.$this->getEnclosure();
        }

        if($field === ''){
            $field = $this->getEnclosure().$field.$this->getEnclosure();
        }

        return $field;
    }

    /**
     * @param string $row
     * @return CSV
     */
    protected function addRow($row){
        $this->rows .= $row;

        return $this;
    }

    /**
     * @return string
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @param string $rows
     * @return CSV
     */
    public function setRows($rows)
    {
        $this->rows = $rows;
        return $this;
    }

    /**
     * @return string
     */
    public function getDelimiter()
    {
        return $this->delimiter;
    }

    /**
     * @param string $delimiter
     * @return CSV
     */
    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;
        return $this;
    }

    /**
     * @return string
     */
    public function getEnclosure()
    {
        return $this->enclosure;
    }

    /**
     * @param string $enclosure
     * @return CSV
     */
    public function setEnclosure($enclosure)
    {
        $this->enclosure = $enclosure;
        return $this;
    }

    /**
     * @return array
     */
    public function getHeaderRow()
    {
        return $this->headerRow;
    }

    /**
     * @param array $headerRow
     * @return CSV
     */
    public function setHeaderRow($headerRow)
    {
        $this->headerRow = $headerRow;

    }
}