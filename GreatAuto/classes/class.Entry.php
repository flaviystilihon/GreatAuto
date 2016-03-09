<?php

class Entry
{
    protected $readyEntry;
    protected $htmlFile;
    
    protected $userName;
    protected $date;
    protected $content;

    public function __construct($userName, $date, $content)
    {
        $this->htmlFile = ENTRYBOX;
        
        $this->userName = $userName;
        $this->date     = $date;
        $this->content  = $content;
        
        $this->buildEntry();
    }
    
    public function buildEntry()
    {
        $this->date = date("d-m-Y, G:i:s", $this->date);
                
        $this->readyEntry = file_get_contents($this->htmlFile);
        $this->readyEntry = str_replace('AUTHOR', $this->userName, $this->readyEntry);
        $this->readyEntry = str_replace('DATE', $this->date, $this->readyEntry);
        $this->readyEntry = str_replace('CONTENT', $this->content, $this->readyEntry);
    }
    
    public function getReadyEntry()
    {
        return $this->readyEntry;
    }
}
