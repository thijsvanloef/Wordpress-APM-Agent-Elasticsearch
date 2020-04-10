<?php

/**
 * Class APM
 */

class APM {

  protected $agent = null;
  protected $transaction = null;

  public function __construct() {

    $config = [
      'appName'     => APM_APPNAME,
      'appVersion'  => APM_APPVERSION,
      'serverUrl'   => APM_SERVERURL,
      'secretToken' => APM_SECRETTOKEN,
      'active'      => APM_ACTIVE,
      'hostname'    => gethostname(),
      'environment' => APM_ENVIRONMENT,
      'env'         => ['DOCUMENT_ROOT', 'REMOTE_ADDR', 'REMOTE_USER', 'APM_ENVIRONMENT']
    ];

    $this->agent = new \PhilKra\Agent($config);

    $this->create_transaction($_SERVER['REQUEST_URI']);

    add_action('wp_loaded', array( $this, 'finish_transaction' ) );

  }

  public function create_transaction($url){

    $mem = $this->getServerMemoryUsage(false);

    $this->agent->putEvent($this->agent->factory()->newMetricset([
      'system.cpu.total.norm.pct' => min(sys_getloadavg()[0]/100, 1),
      'system.memory.total' => $mem['total'],
      'system.memory.actual.free' => $mem['free']
    ]));

    $this->transaction = $this->agent->startTransaction('GET '.$url);

  }

  public function finish_transaction(){

    $this->agent->stopTransaction($this->transaction->getTransactionName());

  }

  function getServerMemoryUsage($getPercentage=true){

    $memoryTotal = null;
    $memoryFree = null;

    if (stristr(PHP_OS, "win")) {
        // Get total physical memory (this is in bytes)
        $cmd = "wmic ComputerSystem get TotalPhysicalMemory";
        @exec($cmd, $outputTotalPhysicalMemory);

        // Get free physical memory (this is in kibibytes!)
        $cmd = "wmic OS get FreePhysicalMemory";
        @exec($cmd, $outputFreePhysicalMemory);

        if ($outputTotalPhysicalMemory && $outputFreePhysicalMemory) {
            // Find total value
            foreach ($outputTotalPhysicalMemory as $line) {
                if ($line && preg_match("/^[0-9]+\$/", $line)) {
                    $memoryTotal = $line;
                    break;
                }
            }

            // Find free value
            foreach ($outputFreePhysicalMemory as $line) {
                if ($line && preg_match("/^[0-9]+\$/", $line)) {
                    $memoryFree = $line;
                    $memoryFree *= 1024;  // convert from kibibytes to bytes
                    break;
                }
            }
        }
    } else {

        if (is_readable("/proc/meminfo")){

            $stats = @file_get_contents("/proc/meminfo");

            if ($stats !== false) {
                // Separate lines
                $stats = str_replace(array("\r\n", "\n\r", "\r"), "\n", $stats);
                $stats = explode("\n", $stats);

                // Separate values and find correct lines for total and free mem
                foreach ($stats as $statLine) {
                    $statLineData = explode(":", trim($statLine));

                    //
                    // Extract size (TODO: It seems that (at least) the two values for total and free memory have the unit "kB" always. Is this correct?
                    //

                    // Total memory
                    if (count($statLineData) == 2 && trim($statLineData[0]) == "MemTotal") {
                        $memoryTotal = trim($statLineData[1]);
                        $memoryTotal = explode(" ", $memoryTotal);
                        $memoryTotal = $memoryTotal[0];
                        $memoryTotal *= 1024;  // convert from kibibytes to bytes
                    }

                    // Free memory
                    if (count($statLineData) == 2 && trim($statLineData[0]) == "MemFree") {
                        $memoryFree = trim($statLineData[1]);
                        $memoryFree = explode(" ", $memoryFree);
                        $memoryFree = $memoryFree[0];
                        $memoryFree *= 1024;  // convert from kibibytes to bytes
                    }
                }
            }
        }
    }

    if (is_null($memoryTotal) || is_null($memoryFree)) {
        return null;
    } else {
        if ($getPercentage) {
            return (100 - ($memoryFree * 100 / $memoryTotal));
        } else {
            return array(
                "total" => $memoryTotal,
                "free" => $memoryFree,
            );
        }
    }
  }

}
