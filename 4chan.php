//$threads = new threads(board="g",catalog=False,page=1);

/**
 * Class threads
 * @board $board the board name
 * @catalog $catalog boolean value whether or not
 * to select the board's catalog
 * @page $page the boad's page  number
 */
 
 <?php
class threads
{
    /**
     * @param string $board
     * @param bool|false $catalog
     * @param int $page
     */
    public function __construct($board='',$catalog=false,$page=1) {
        $this->board = $board;
        $this->catalog = $catalog;
        $this->page = $page;
    }

    /**
     * @param string $uri - resource url
     * @return array  $response JSON response encoded into an array
     */
    public function _get($uri) {

        $dt = new DateTime('UTC');
        $GMT_time = $dt->format('D, d M Y H:i:s \G\M\T');

        $request = curl_init();

        curl_setopt_array($request, array(CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => array("If-Moified-Since: {$GMT_time}"),
            CURLOPT_URL => $uri));


        $response = curl_exec($request);

        curl_close($request);

        return $response;

    }

    /**
     * @return array Return an associative array with 4chan thread data
     */
    public function getThreads() {
        if (!$this->catalog)

            return json_decode($this->_get("http://a.4cdn.org/{$this->board}/threads.json"),TRUE);

        return json_decode($this->_get("http://a.4cdn.org/{$this->board}/catalog.json"));

        }
}
?>
