<?php
/**
 * 遍历目录，打包成zip格式
 */
class traverseDir{
    public $currentdir;//当前目录
    public $filename;//文件名
    public $fileinfo;//用于保存当前目录下的所有文件名和目录名以及文件大小
    public $savepath;
    public function __construct($curpath,$savepath){
        $this->currentdir=$curpath;//返回当前目录
        $this->savepath=$savepath;//返回当前目录
    }        
    //遍历目录
    public function scandir($filepath){
        if (is_dir($filepath)){
                $arr=scandir($filepath);
                foreach ($arr as $k=>$v){
                    $this->fileinfo[$v][]=$this->getfilesize($v);
                }
            }else {
                echo "<script>alert('当前目录不是有效目录');</script>";
            }
    }
    /**
     * 返回文件的大小
     *
     * @param string $filename 文件名
     * @return 文件大小(KB)
     */
    public function getfilesize($fname){
        return filesize($fname)/1024;
    }
    
    /**
     * 压缩文件(zip格式)
     */
    public function tozip($items){ 
        $zip=new ZipArchive();
        $zipname=date('YmdHis',time());
        if (!file_exists($zipname)){
            $zip->open($savepath.$zipname.'.zip',ZipArchive::OVERWRITE);//创建一个空的zip文件
            for ($i=0;$i<count($items);$i++){
                $zip->addFile($this->currentdir.'/'.$items[$i],$items[$i]);
            }
            $zip->close();
            $dw=new download($zipname.'.zip',$savepath); //下载文件
            $dw->getfiles();
            unlink($savepath.$zipname.'.zip'); //下载完成后要进行删除   
        }
    }
}

/**
 * 下载文件
 *
 */
class download{
    protected $_filename;
    protected $_filepath;
    protected $_filesize;//文件大小
    protected $savepath;//文件大小
    public function __construct($filename,$savepath){
        $this->_filename=$filename;
        $this->_filepath=$savepath.$filename;
    }
    //获取文件名
    public function getfilename(){
        return $this->_filename;
    }
    
    //获取文件路径（包含文件名）
    public function getfilepath(){
        return $this->_filepath;
    }
    
    //获取文件大小
    public function getfilesize(){
        return $this->_filesize=number_format(filesize($this->_filepath)/(1024*1024),2);//去小数点后两位
    }
    //下载文件的功能
    public function getfiles(){
        //检查文件是否存在
        if (file_exists($this->_filepath)){
            //打开文件
            $file = fopen($this->_filepath,"r");
            //返回的文件类型
            Header("Content-type: application/octet-stream");
            //按照字节大小返回
            Header("Accept-Ranges: bytes");
            //返回文件的大小
            Header("Accept-Length: ".filesize($this->_filepath));
            //这里对客户端的弹出对话框，对应的文件名
            Header("Content-Disposition: attachment; filename=".$this->_filename);
            //修改之前，一次性将数据传输给客户端
            echo fread($file, filesize($this->_filepath));
            //修改之后，一次只传输1024个字节的数据给客户端
            //向客户端回送数据
            $buffer=1024;//
            //判断文件是否读完
            while (!feof($file)) {
                //将文件读入内存
                $file_data=fread($file,$buffer);
                //每次向客户端回送1024个字节的数据
                echo $file_data;
            }
            
            fclose($file);
        }else {
            echo "<script>alert('对不起,您要下载的文件不存在');</script>";
        }
    }
}