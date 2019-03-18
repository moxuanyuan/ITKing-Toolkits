<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Server Info</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Custom styles for this template -->
    <style>
    body{font-size:.875rem}.feather{width:16px;height:16px;vertical-align:text-bottom}.sidebar{position:fixed;top:0;bottom:0;left:0;z-index:100;padding:0;box-shadow:inset -1px 0 0 rgba(0,0,0,.1)}.sidebar-sticky{position:-webkit-sticky;position:sticky;top:48px;height:calc(100vh - 48px);padding-top:.5rem;overflow-x:hidden;overflow-y:auto}.sidebar .nav-link{font-weight:500;color:#333}.sidebar .nav-link .feather{margin-right:4px;color:#999}.sidebar .nav-link.active{color:#007bff}.sidebar .nav-link.active .feather,.sidebar .nav-link:hover .feather{color:inherit}.sidebar-heading{font-size:.75rem;text-transform:uppercase}.navbar-brand{padding-top:.75rem;padding-bottom:.75rem;font-size:1rem;background-color:rgba(0,0,0,.25);box-shadow:inset -1px 0 0 rgba(0,0,0,.25)}.navbar .form-control{padding:.75rem 1rem;border-width:0;border-radius:0}.form-control-dark{color:#fff;background-color:rgba(255,255,255,.1);border-color:rgba(255,255,255,.1)}.form-control-dark:focus{border-color:transparent;box-shadow:0 0 0 3px rgba(255,255,255,.25)}.border-top{border-top:1px solid #e5e5e5}.border-bottom{border-bottom:1px solid #e5e5e5}a{text-decoration:none!important}.bg-light{background-color:#FFF!important}.width-35{width:35%}.width-15{width:15%}.width-25{width:25%}.color-red{color:red}.color-green{color:green}
    </style>
  </head>
  <body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Server Info</a>
    </nav>
    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <?php $formData=sessionPostData();
              // echo '<pre>';
              // print_r($formData);
            ?>
            <form action="" id="checkForm" class="p-2">
              <h3 class="d-flex justify-content-between align-items-center pb-3  mt-2 mb-1 border-bottom">
                <span>MySQL 检测</span>
              </h3>
              <div class="form-group">
                <label for="inputMySQLHost">Host</label>
                <input type="text" class="form-control form-control-sm" id="inputMySQLHost" name="mysqlHost" value="<?php echo $formData['mysqlHost'] ?>"  placeholder="Enter Host">
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="exampleInputEmail1">Username</label>
                  <input type="text" class="form-control form-control-sm" id="inputUsername" name="mysqlUsername" value="<?php echo $formData['mysqlUsername'] ?>"  placeholder="Enter Username">
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleInputEmail1">Password</label>
                  <input type="text" class="form-control form-control-sm" id="inputPassword" name="mysqlPassword" value="<?php echo $formData['mysqlPassword'] ?>"  placeholder="Enter Password">
                </div>
              </div>
              <h3 class="d-flex justify-content-between align-items-center pb-3  mt-2 mb-1 border-bottom">
                <span>Email 检测</span>
              </h3>
              <div class="form-group">
                <label for="inputEmail">Send Test Email To</label>
                <input type="text" class="form-control form-control-sm" id="inputEmail" name="email" value="<?php echo $formData['email'] ?>"  placeholder="Default send to it@hknow.net">
              </div>
              <h3 class="d-flex justify-content-between align-items-center pb-3  mt-2 mb-1 border-bottom">
                <span>Remote SMTP</span>
              </h3>
              <div class="form-group">
                <label for="inputSmtpHost">Host</label>
                <input type="text" class="form-control form-control-sm" id="inputSmtpHost" value="<?php echo $formData['smtpHost'] ?>"  name="smtpHost" placeholder="Enter Host">
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputSmtpPort">Port</label>
                  <input type="text" class="form-control form-control-sm" id="inputSmtpPort" name="smtpPort"  value="<?php echo $formData['smtpPort'] ?>" placeholder="Enter Port">
                </div>
                <div class="form-group col-md-6">
                  <label for="inputSmtpSSL">SSL</label>
                  <select id="inputSmtpSSL" name="smtpSSL" class="form-control form-control-sm">
                          <option<?php echo $formData['smtpSSL']=='No'?' selected':'' ?>>No</option>
                          <option<?php echo $formData['smtpSSL']=='Yes'?' selected':'' ?>>Yes</option>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputSmtpUsername">Username</label>
                  <input type="text" class="form-control form-control-sm" id="inputSmtpUsername" name="smtpUsername" value="<?php echo $formData['smtpUsername'] ?>" placeholder="Enter Username">
                </div>
                <div class="form-group col-md-6">
                  <label for="inputSmtpPassword">Password</label>
                  <input type="password" class="form-control form-control-sm" id="inputSmtpPassword" name="smtpPassword" value="<?php echo $formData['smtpPassword'] ?>"   placeholder="Enter Password">
                </div>
              </div>
              <p style="text-align: right">
                <button type="button" class="btn btn-secondary" id="btn-clean">Clean</button>
                <button type="button" class="btn btn-primary" id="btn-submit">Submit</button>
              </p>
            </form>
          </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
          <div class="table-responsive">
            <table class="table table-bordered table-sm">
              <thead class="thead-dark">
                <tr>
                  <th colspan="4">重要参数</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 15%">服务器域名/IP</td>
                  <td style="width: 35%"><?php echo serverIp(); ?></td>
                  <td style="width: 15%">你的IP地址</td>
                  <td style="width: 35%"><?php echo @$_SERVER['REMOTE_ADDR'];?></td>
                </tr>
                <tr>
                  <td>服务器端口</td>
                  <td><?php echo $_SERVER['SERVER_PORT'];?></td>
                  <td>绝对路径</td>
                  <td>
                    <?php echo $_SERVER['DOCUMENT_ROOT']?str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']):str_replace('\\','/',dirname(__FILE__));?>
                  </td>
                </tr>
                <tr>
                  <td>操作系统</td>
                  <td>
                    <?php
                    $os = explode(" ", php_uname());
                    echo $os[0];?> &nbsp;内核版本：<?php if('/'==DIRECTORY_SEPARATOR){echo $os[2];}else{echo $os[1];} ?>
                  </td>
                  <td>服务器解译引擎</td>
                  <td><?php echo server_software() ?></td>
                </tr>
                <tr>
                  <td>PHP 版本</td>
                  <td><?php echo PHP_VERSION;?></td>
                  <td>MySQL 版本</td>
                  <td><?php echo mysql_version(); ?></td>
                </tr>
                <tr>
                  <td>脚本超时时间</td>
                  <td><?php echo $max_execution_time;?></td>
                  <td>脚本占用最大内存</td>
                  <td><?php echo show("memory_limit");?></td>
                </tr>
                <tr>
                  <td>上传文件最大限制</td>
                  <td><?php echo show("upload_max_filesize");?></td>
                  <td>POST提交最大限制</td>
                  <td><?php echo show("post_max_size");?></td>
                </tr>
                <tr>
                  <td>Local Mail</td>
                  <td>
                  <?php

                      if(isset($_SESSION['localMail']))
                      {
                        echo_yes_no($_SESSION['localMail']);
                      }else
                      {
                        echo '未检测';
                      }

                   ?>
                  </td>
                  <td>Remote SMTP</td>
                  <td>

                    <?php

                        if(isset($_SESSION['remoteSMTP']))
                        {
                          echo_yes_no($_SESSION['remoteSMTP']);
                        }else
                        {
                          echo '未检测';
                        }

                     ?>
                  </td>
                </tr>
                <tr>
                  <td>MySQL 连接</td>
                  <td>
                    <?php if(isset($_SESSION['mysqlConnect'])): ?>
                      <?php
                        echo_yes_no($_SESSION['mysqlConnect']);

                        if(!$_SESSION['mysqlConnect'] && isset($_SESSION['mysqlError']))
                        {
                          echo ' '.$_SESSION['mysqlError'];
                        }
                       ?>
                    <?php else: ?>
                       未检测
                    <?php endif; ?>
                  </td>
                  <td>MySQL 权限</td>
                  <td>
                    <?php if(isset($_SESSION['mysqlConnect'])): ?>
                      <?php
                        if($_SESSION['mysqlConnect'] && isset($_SESSION['mysqlPrivileges']) && $_SESSION['mysqlPrivileges'])
                        {
                            foreach ($_SESSION['mysqlPrivileges'] as $value) {
                              echo "{$value[0]} <br>";
                            }
                        }else
                        {
                          echo_yes_no($_SESSION['mysqlConnect']);
                        }

                       ?>
                    <?php else: ?>
                       未检测
                    <?php endif; ?>
                  </td>
                </tr>
                <tr>
                  <td>MySQL 数据库</td>
                  <td colspan="3">
                    <?php if(isset($_SESSION['mysqlConnect'])): ?>
                      <?php
                        if($_SESSION['mysqlConnect'] && isset($_SESSION['mysqlDatabases']) && $_SESSION['mysqlDatabases'])
                        {
                            foreach ($_SESSION['mysqlDatabases'] as $value) {
                              echo " <span class='badge badge-light'>{$value[0]}</span>";
                            }
                        }else
                        {
                          echo_yes_no($_SESSION['mysqlConnect']);
                        }

                       ?>
                    <?php else: ?>
                       未检测
                    <?php endif; ?>
                  </td>
                </tr>
             </tbody>
            </table>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-sm">
              <thead class="thead-dark">
                <tr>
                  <th >PHP已编译模块</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <?php

                    $able=get_loaded_extensions();

                    foreach ($able as $key=>$value) {

                      // if ($key!=0 && $key%20==0) {

                      //   echo '<br />';

                      // }

                      // echo "$value&nbsp;&nbsp;";
                      echo " <span class='badge badge-light'>{$value}</span>";

                    }

                    ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-sm">
              <thead class="thead-dark">
                <tr>
                  <th colspan="4">PHP相关参数</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="width-25">PHP信息（phpinfo）</td>
                  <td class="width-25">
                      <?php
                        $disFuns=get_cfg_var("disable_functions");
                      ?>
                      <?php if(preg_match('/phpinfo/',$disFuns)):?>
                        <i data-feather="x"></i>
                      <?php else: ?>
                        <a href="<?php echo $urlSelf  ?>?act=phpinfo" target="_blank">PHPINFO <i data-feather="external-link"></i></a>
                      <?php endif; ?>
                  </td>
                  <td class="width-25">PHP版本（php_version）</td>
                  <td class="width-25"><?php echo PHP_VERSION;?></td>
                </tr>
                 <tr>

                   <td>PHP运行方式</td>

                   <td><?php echo strtoupper(php_sapi_name());?></td>

                   <td>脚本占用最大内存（memory_limit）</td>

                   <td><?php echo show("memory_limit");?></td>

                 </tr>

                 <tr>

                   <td>PHP安全模式（safe_mode）</td>

                   <td><?php echo show("safe_mode");?></td>

                   <td>POST方法提交最大限制（post_max_size）</td>

                   <td><?php echo show("post_max_size");?></td>

                 </tr>

                 <tr>

                   <td>上传文件最大限制（upload_max_filesize）</td>

                   <td><?php echo show("upload_max_filesize");?></td>

                   <td>浮点型数据显示的有效位数（precision）</td>

                   <td><?php echo show("precision");?></td>

                 </tr>

                 <tr>

                   <td>脚本超时时间（max_execution_time）</td>

                   <td><?php echo $max_execution_time;?></td>

                   <td>socket超时时间（default_socket_timeout）</td>

                   <td><?php echo $default_socket_timeout;?></td>

                 </tr>

                 <tr>

                   <td>PHP页面根目录（doc_root）</td>

                   <td><?php echo show("doc_root");?></td>

                   <td>用户根目录（user_dir）</td>

                   <td><?php echo show("user_dir");?></td>

                 </tr>

                 <tr>

                   <td>dl()函数（enable_dl）</td>

                   <td><?php echo show("enable_dl");?></td>

                   <td>指定包含文件目录（include_path）</td>

                   <td><?php echo show("include_path");?></td>

                 </tr>

                 <tr>

                   <td>显示错误信息（display_errors）</td>

                   <td><?php echo show("display_errors");?></td>

                   <td>自定义全局变量（register_globals）</td>

                   <td><?php echo show("register_globals");?></td>

                 </tr>

                 <tr>

                   <td>数据反斜杠转义（magic_quotes_gpc）</td>

                   <td><?php echo show("magic_quotes_gpc");?></td>

                   <td>"&lt;?...?&gt;"短标签（short_open_tag）</td>

                   <td><?php echo show("short_open_tag");?></td>

                 </tr>

                 <tr>

                   <td>"&lt;% %&gt;"ASP风格标记（asp_tags）</td>

                   <td><?php echo show("asp_tags");?></td>

                   <td>忽略重复错误信息（ignore_repeated_errors）</td>

                   <td><?php echo show("ignore_repeated_errors");?></td>

                 </tr>

                 <tr>

                   <td>忽略重复的错误源（ignore_repeated_source）</td>

                   <td><?php echo show("ignore_repeated_source");?></td>

                   <td>报告内存泄漏（report_memleaks）</td>

                   <td><?php echo show("report_memleaks");?></td>

                 </tr>

                 <tr>

                   <td>自动字符串转义（magic_quotes_gpc）</td>

                   <td><?php echo show("magic_quotes_gpc");?></td>

                   <td>外部字符串自动转义（magic_quotes_runtime）</td>

                   <td><?php echo show("magic_quotes_runtime");?></td>

                 </tr>

                 <tr>

                   <td>打开远程文件（allow_url_fopen）</td>

                   <td><?php echo show("allow_url_fopen");?></td>

                   <td>声明argv和argc变量（register_argc_argv）</td>

                   <td><?php echo show("register_argc_argv");?></td>

                 </tr>

                 <tr>
                   <td>Cookie 支持</td>
                   <td><?php echo_yes_no(isset($_COOKIE));?></td>
                   <td>拼写检查（ASpell Library）</td>
                   <td><?php showIsFun("aspell_check_raw");?></td>
                 </tr>
                  <tr>
                   <td>高精度数学运算（BCMath）</td>
                   <td><?php showIsFun("bcadd");?></td>
                   <td>PREL相容语法（PCRE）</td>
                   <td><?php showIsFun("preg_match");?></td>
                  <tr>
                   <td>PDF文档支持</td>
                   <td><?php showIsFun("pdf_close");?></td>
                   <td>SNMP网络管理协议</td>
                   <td><?php showIsFun("snmpget");?></td>
                 </tr>
                  <tr>
                   <td>VMailMgr邮件处理</td>
                   <td><?php showIsFun("vm_adduser");?></td>
                   <td>Curl支持</td>
                   <td><?php showIsFun("curl_init");?></td>
                 </tr>
                 <tr>
                   <td>SMTP支持</td>
                   <td colspan="3"><?php echo show("SMTP")?></td>
                 </tr>
                 <tr>
                    <td>默认支持函数（enable_functions）</td>
                    <td colspan="3"><a href='<?php echo $urlSelf;?>?act=function' target='_blank' class='static'>查看详细 <i data-feather='external-link'></i></a></td>
                 </tr>
                 <tr>
                    <td>被禁用的函数（disable_functions）</td>
                    <td colspan="3" class="word">
                       <?php
                         $disFuns=get_cfg_var("disable_functions");
                         if(empty($disFuns))
                         {
                           echo_yes_no(false);
                         }
                         else
                         {
                          //echo $disFuns;
                          $disFuns_array =  explode(',',$disFuns);
                          foreach ($disFuns_array as $key=>$value)
                          {
                            if ($key!=0 && $key%5==0) {
                              echo '<br />';
                          }
                          echo "$value&nbsp;&nbsp;";
                         }
                         }

                       ?>
                    </td>
                  </tr>
              </tbody>
            </table>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-sm">
              <thead class="thead-dark">
                <tr>
                  <th colspan="4">组件支持</th>
                </tr>
              </thead>
              <tbody>
                <tr>

                  <td class="width-25">FTP支持：</td>

                  <td class="width-25"><?php showIsFun("ftp_login");?></td>

                  <td class="width-25">XML解析支持：</td>

                  <td class="width-25"><?php showIsFun("xml_set_object");?></td>

                </tr>

                <tr>

                  <td>Session支持：</td>

                  <td><?php showIsFun("session_start");?></td>

                  <td>Socket支持：</td>

                  <td><?php showIsFun("socket_accept");?></td>

                </tr>

                <tr>

                  <td>Calendar支持</td>

                  <td><?php showIsFun('cal_days_in_month');?>
                </td>

                  <td>允许URL打开文件：</td>

                  <td><?php echo show("allow_url_fopen");?></td>

                </tr>

                <tr>

                  <td>GD库支持：</td>

                  <td>

                  <?php

                      if(function_exists('gd_info')) {

                          $gd_info = @gd_info();

                        echo $gd_info["GD Version"];

                    }else{echo_yes_no(false);}

                ?></td>

                  <td>压缩文件支持(Zlib)：</td>

                  <td><?php showIsFun("gzclose");?></td>

                </tr>

                <tr>

                  <td>IMAP电子邮件系统函数库：</td>

                  <td><?php showIsFun("imap_close");?></td>

                  <td>历法运算函数库：</td>

                  <td><?php showIsFun("JDToGregorian");?></td>

                </tr>

                <tr>

                  <td>正则表达式函数库：</td>

                  <td><?php showIsFun("preg_match");?></td>

                  <td>WDDX支持：</td>

                  <td><?php showIsFun("wddx_add_vars");?></td>

                </tr>

                <tr>

                  <td>Iconv编码转换：</td>

                  <td><?php showIsFun("iconv");?></td>

                  <td>mbstring：</td>

                  <td><?php showIsFun("mb_eregi");?></td>

                </tr>

                <tr>

                  <td>高精度数学运算：</td>

                  <td><?php showIsFun("bcadd");?></td>

                  <td>LDAP目录协议：</td>

                  <td><?php showIsFun("ldap_close");?></td>

                </tr>

                <tr>

                  <td>MCrypt加密处理：</td>

                  <td><?php showIsFun("mcrypt_cbc");?></td>

                  <td>哈稀计算：</td>

                  <td><?php showIsFun("mhash_count");?></td>

                </tr>
              </tbody>
            </table>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-sm">
              <thead class="thead-dark">
                <tr>
                  <th colspan="4">第三方组件</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="width-25">Zend版本</td>
                  <td class="width-25">
                  <?php
                    $zend_version = zend_version();

                    echo (empty($zend_version))?yes_no(0):$zend_version;
                  ?>
                  </td>
                  <td class="width-25">
                      <?php
                        if($PHP_VERSION_mini  > '5.2')
                        {
                          echo "ZendGuardLoader[启用]";
                        }
                        else
                        {
                          echo "Zend Optimizer";
                        }
                      ?>
                </td>
                <td class="width-25">
                <?php
                  if($PHP_VERSION_mini  > '5.2')
                  {
                    echo show('zend_loader.enable');
                  }
                  else
                  {
                    if(function_exists('zend_optimizer_version'))
                    {
                      echo zend_optimizer_version();
                    }
                    else
                    {
                      $flag=(get_cfg_var("zend_optimizer.optimization_level")||get_cfg_var("zend_extension_manager.optimizer_ts")||get_cfg_var("zend.ze1_compatibility_mode")||get_cfg_var("zend_extension_ts"));
                      echo_yes_no($flag);
                    }
                  }
                ?>
                </td>
                </tr>
                <tr>
                  <td>eAccelerator</td>
                  <td>
                   <?php
                     if((phpversion('eAccelerator'))!='')
                     {
                        echo phpversion('eAccelerator');
                     }
                     else
                     {
                        echo_yes_no(0);
                     }
                   ?>
                  </td>
                  <td>ioncube</td>
                  <td>
                  <?php
                    if(extension_loaded('ionCube Loader'))
                    {
                      $ys = ioncube_loader_iversion();
                      $gm = ".".(int)substr($ys,3,2);
                      echo ionCube_Loader_version().$gm;
                    }
                    else
                    {
                      echo_yes_no(0);
                    }
                    ?>
                  </td>
                </tr>
                <tr>
                  <td>XCache</td>
                  <td>
                   <?php
                     if((phpversion('XCache'))!='')
                     {
                        echo phpversion('XCache');
                     }
                     else
                     {
                        echo_yes_no(0);
                     }
                   ?>
                  </td>
                  <td>APC</td>
                  <td>
                   <?php
                     if((phpversion('APC'))!='')
                     {
                        echo phpversion('APC');
                     }
                     else
                     {
                        echo_yes_no(0);
                     }
                   ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-sm">
              <thead class="thead-dark">
                <tr>
                  <th colspan="4" >数据库支持</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="width-25">MySQL 数据库：</td>

                  <td class="width-25">  <?php echo mysql_version(); ?> </td>

                  <td class="width-25">ODBC 数据库：</td>

                  <td class="width-25"><?php showIsFun("odbc_close");?></td>
                </tr>
                <tr>
                  <td>Oracle 数据库：</td>

                  <td><?php showIsFun("ora_close");?></td>

                  <td>SQL Server 数据库：</td>

                  <td><?php showIsFun("mssql_close");?></td>

                </tr>

                <tr>

                  <td>dBASE 数据库：</td>

                  <td><?php showIsFun("dbase_close");?></td>

                  <td>mSQL 数据库：</td>

                  <td><?php showIsFun("msql_close");?></td>

                </tr>

                <tr>

                  <td>SQLite 数据库：</td>

                  <td>
                    <?php
                      if(extension_loaded('sqlite3'))
                      {
                        $sqliteVer = SQLite3::version();
                        echo_yes_no(1);
                        echo "SQLite3　Ver ";
                        echo $sqliteVer['versionString'];
                      }
                      else
                      {
                        showIsFun("sqlite_close");
                        if(isfun("sqlite_close"))
                        {
                          echo "&nbsp; 版本： ".@sqlite_libversion();
                        }
                      }
                    ?>
                  </td>

                  <td>Hyperwave 数据库：</td>

                  <td><?php showIsFun("hw_close");?></td>

                </tr>

                <tr>

                  <td>Postgre SQL 数据库：</td>

                  <td><?php showIsFun("pg_close"); ?></td>

                  <td>Informix 数据库：</td>

                  <td><?php showIsFun("ifx_close");?></td>

                </tr>
                <tr>
                  <td>DBA 数据库：</td>
                  <td><?php showIsFun("dba_close");?></td>
                  <td>DBM 数据库：</td>
                  <td><?php showIsFun("dbmclose");?></td>
                </tr>
                <tr>
                  <td>FilePro 数据库：</td>
                  <td><?php showIsFun("filepro_fieldcount");?></td>
                  <td>SyBase 数据库：</td>
                  <td><?php showIsFun("sybase_close");?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </main>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <style>
    .bubbling-spinner,.piano-spinner{-webkit-transform:translateZ(0);-ms-transform:translateZ(0)}.p-loading-element-mask{position:relative}.p-loading-container{width:100%;height:100%;position:absolute;overflow:hidden;text-align:center;border-radius:inherit;background-color:rgba(0,0,0,.6);z-index:1}.p-loading-fontawesome{font-size:50px;color:#fff;top:calc(44%);position:relative}.piano-spinner,.piano-spinner:after,.piano-spinner:before{background:#fff;-webkit-animation:load1 1s infinite ease-in-out;animation:load1 1s infinite ease-in-out;width:1em;height:4em}.piano-spinner:after,.piano-spinner:before{position:absolute;top:0;content:''}.piano-spinner:before{left:-1.5em;-webkit-animation-delay:-.32s;animation-delay:-.32s}.piano-spinner{text-indent:-9999em;margin:0 auto;position:relative;font-size:11px;transform:translateZ(0);-webkit-animation-delay:-.16s;animation-delay:-.16s;top:calc(47%)}.piano-spinner:after{left:1.5em}@-webkit-keyframes load1{0%,100%,80%{box-shadow:0 0 #fff;height:4em}40%{box-shadow:0 -2em #fff;height:5em}}@keyframes load1{0%,100%,80%{box-shadow:0 0 #fff;height:4em}40%{box-shadow:0 -2em #fff;height:5em}}.bubble-ride-spinner,.bubbling-spinner{text-indent:-9999em;width:1em;height:1em;border-radius:50%;margin:0 auto;position:relative}.bubbling-spinner{font-size:20px;-webkit-animation:load4 1.3s infinite linear;animation:load4 1.3s infinite linear;transform:translateZ(0);top:calc(45%)}@-webkit-keyframes load4{0%,100%{box-shadow:0 -3em 0 .2em #fff,2em -2em 0 0 #fff,3em 0 0 -1em #fff,2em 2em 0 -1em #fff,0 3em 0 -1em #fff,-2em 2em 0 -1em #fff,-3em 0 0 -1em #fff,-2em -2em 0 0 #fff}12.5%{box-shadow:0 -3em 0 0 #fff,2em -2em 0 .2em #fff,3em 0 0 0 #fff,2em 2em 0 -1em #fff,0 3em 0 -1em #fff,-2em 2em 0 -1em #fff,-3em 0 0 -1em #fff,-2em -2em 0 -1em #fff}25%{box-shadow:0 -3em 0 -.5em #fff,2em -2em 0 0 #fff,3em 0 0 .2em #fff,2em 2em 0 0 #fff,0 3em 0 -1em #fff,-2em 2em 0 -1em #fff,-3em 0 0 -1em #fff,-2em -2em 0 -1em #fff}37.5%{box-shadow:0 -3em 0 -1em #fff,2em -2em 0 -1em #fff,3em 0 0 0 #fff,2em 2em 0 .2em #fff,0 3em 0 0 #fff,-2em 2em 0 -1em #fff,-3em 0 0 -1em #fff,-2em -2em 0 -1em #fff}50%{box-shadow:0 -3em 0 -1em #fff,2em -2em 0 -1em #fff,3em 0 0 -1em #fff,2em 2em 0 0 #fff,0 3em 0 .2em #fff,-2em 2em 0 0 #fff,-3em 0 0 -1em #fff,-2em -2em 0 -1em #fff}62.5%{box-shadow:0 -3em 0 -1em #fff,2em -2em 0 -1em #fff,3em 0 0 -1em #fff,2em 2em 0 -1em #fff,0 3em 0 0 #fff,-2em 2em 0 .2em #fff,-3em 0 0 0 #fff,-2em -2em 0 -1em #fff}75%{box-shadow:0 -3em 0 -1em #fff,2em -2em 0 -1em #fff,3em 0 0 -1em #fff,2em 2em 0 -1em #fff,0 3em 0 -1em #fff,-2em 2em 0 0 #fff,-3em 0 0 .2em #fff,-2em -2em 0 0 #fff}87.5%{box-shadow:0 -3em 0 0 #fff,2em -2em 0 -1em #fff,3em 0 0 -1em #fff,2em 2em 0 -1em #fff,0 3em 0 -1em #fff,-2em 2em 0 0 #fff,-3em 0 0 0 #fff,-2em -2em 0 .2em #fff}}@keyframes load4{0%,100%{box-shadow:0 -3em 0 .2em #fff,2em -2em 0 0 #fff,3em 0 0 -1em #fff,2em 2em 0 -1em #fff,0 3em 0 -1em #fff,-2em 2em 0 -1em #fff,-3em 0 0 -1em #fff,-2em -2em 0 0 #fff}12.5%{box-shadow:0 -3em 0 0 #fff,2em -2em 0 .2em #fff,3em 0 0 0 #fff,2em 2em 0 -1em #fff,0 3em 0 -1em #fff,-2em 2em 0 -1em #fff,-3em 0 0 -1em #fff,-2em -2em 0 -1em #fff}25%{box-shadow:0 -3em 0 -.5em #fff,2em -2em 0 0 #fff,3em 0 0 .2em #fff,2em 2em 0 0 #fff,0 3em 0 -1em #fff,-2em 2em 0 -1em #fff,-3em 0 0 -1em #fff,-2em -2em 0 -1em #fff}37.5%{box-shadow:0 -3em 0 -1em #fff,2em -2em 0 -1em #fff,3em 0 0 0 #fff,2em 2em 0 .2em #fff,0 3em 0 0 #fff,-2em 2em 0 -1em #fff,-3em 0 0 -1em #fff,-2em -2em 0 -1em #fff}50%{box-shadow:0 -3em 0 -1em #fff,2em -2em 0 -1em #fff,3em 0 0 -1em #fff,2em 2em 0 0 #fff,0 3em 0 .2em #fff,-2em 2em 0 0 #fff,-3em 0 0 -1em #fff,-2em -2em 0 -1em #fff}62.5%{box-shadow:0 -3em 0 -1em #fff,2em -2em 0 -1em #fff,3em 0 0 -1em #fff,2em 2em 0 -1em #fff,0 3em 0 0 #fff,-2em 2em 0 .2em #fff,-3em 0 0 0 #fff,-2em -2em 0 -1em #fff}75%{box-shadow:0 -3em 0 -1em #fff,2em -2em 0 -1em #fff,3em 0 0 -1em #fff,2em 2em 0 -1em #fff,0 3em 0 -1em #fff,-2em 2em 0 0 #fff,-3em 0 0 .2em #fff,-2em -2em 0 0 #fff}87.5%{box-shadow:0 -3em 0 0 #fff,2em -2em 0 -1em #fff,3em 0 0 -1em #fff,2em 2em 0 -1em #fff,0 3em 0 -1em #fff,-2em 2em 0 0 #fff,-3em 0 0 0 #fff,-2em -2em 0 .2em #fff}}.bubble-ride-spinner{font-size:90px;overflow:hidden;-webkit-transform:translateZ(0);-ms-transform:translateZ(0);transform:translateZ(0);-webkit-animation:load6 1.7s infinite ease;animation:load6 1.7s infinite ease;top:calc(38%)}@-webkit-keyframes load6{0%{-webkit-transform:rotate(0);transform:rotate(0);box-shadow:0 -.83em 0 -.4em #fff,0 -.83em 0 -.42em #fff,0 -.83em 0 -.44em #fff,0 -.83em 0 -.46em #fff,0 -.83em 0 -.477em #fff}5%,95%{box-shadow:0 -.83em 0 -.4em #fff,0 -.83em 0 -.42em #fff,0 -.83em 0 -.44em #fff,0 -.83em 0 -.46em #fff,0 -.83em 0 -.477em #fff}10%,59%{box-shadow:0 -.83em 0 -.4em #fff,-.087em -.825em 0 -.42em #fff,-.173em -.812em 0 -.44em #fff,-.256em -.789em 0 -.46em #fff,-.297em -.775em 0 -.477em #fff}20%{box-shadow:0 -.83em 0 -.4em #fff,-.338em -.758em 0 -.42em #fff,-.555em -.617em 0 -.44em #fff,-.671em -.488em 0 -.46em #fff,-.749em -.34em 0 -.477em #fff}38%{box-shadow:0 -.83em 0 -.4em #fff,-.377em -.74em 0 -.42em #fff,-.645em -.522em 0 -.44em #fff,-.775em -.297em 0 -.46em #fff,-.82em -.09em 0 -.477em #fff}100%{-webkit-transform:rotate(360deg);transform:rotate(360deg);box-shadow:0 -.83em 0 -.4em #fff,0 -.83em 0 -.42em #fff,0 -.83em 0 -.44em #fff,0 -.83em 0 -.46em #fff,0 -.83em 0 -.477em #fff}}@keyframes load6{0%{-webkit-transform:rotate(0);transform:rotate(0);box-shadow:0 -.83em 0 -.4em #fff,0 -.83em 0 -.42em #fff,0 -.83em 0 -.44em #fff,0 -.83em 0 -.46em #fff,0 -.83em 0 -.477em #fff}5%,95%{box-shadow:0 -.83em 0 -.4em #fff,0 -.83em 0 -.42em #fff,0 -.83em 0 -.44em #fff,0 -.83em 0 -.46em #fff,0 -.83em 0 -.477em #fff}10%,59%{box-shadow:0 -.83em 0 -.4em #fff,-.087em -.825em 0 -.42em #fff,-.173em -.812em 0 -.44em #fff,-.256em -.789em 0 -.46em #fff,-.297em -.775em 0 -.477em #fff}20%{box-shadow:0 -.83em 0 -.4em #fff,-.338em -.758em 0 -.42em #fff,-.555em -.617em 0 -.44em #fff,-.671em -.488em 0 -.46em #fff,-.749em -.34em 0 -.477em #fff}38%{box-shadow:0 -.83em 0 -.4em #fff,-.377em -.74em 0 -.42em #fff,-.645em -.522em 0 -.44em #fff,-.775em -.297em 0 -.46em #fff,-.82em -.09em 0 -.477em #fff}100%{-webkit-transform:rotate(360deg);transform:rotate(360deg);box-shadow:0 -.83em 0 -.4em #fff,0 -.83em 0 -.42em #fff,0 -.83em 0 -.44em #fff,0 -.83em 0 -.46em #fff,0 -.83em 0 -.477em #fff}}
    </style>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
    /*
     *  p-loading - v1.2.0
     *  Loading mask plugin for jQuery.
     *  http://joseshiru.github.io/p-loading/
     *
     *  Made by Jose Zuniga
     *  Under MIT License
     */
    !function(a){"use strict";a.fn.ploading=function(b){var c,d=this,e={},f={},g={};return e.definePluginSettings=function(){var d,e,f;f=function(a){a.hide()},e=function(a){a.show()},d={action:"show",containerHTML:"<div/>",containerAttrs:{},containerClass:"p-loading-container",spinnerHTML:"<div/>",spinnerAttrs:{},spinnerClass:"p-loading-spinner piano-spinner",onShowContainer:void 0,onHideContainer:void 0,onDestroyContainer:void 0,hideAnimation:f,showAnimation:e,destroyAfterHide:!1,idPrefix:"loader",pluginNameSpace:"p-loader",maskHolder:!0,maskColor:"rgba(0,0,0,0.6)",useAddOns:[]},c=a.extend(d,a.fn.ploading.defaults,b)},e.definePublicVariables=function(){"initialized"!==a.fn.ploading.state&&(a.fn.ploading.state="starting",a.fn.ploading.addOnManager={},a.fn.ploading.addOnManager.events={})},e.definePrivateActions=function(){g.buildPluginMarkup=function(){var b,e={};e.$container=function(){var b=c.containerHTML,e=a(b),f=Math.round((new Date).getTime()+100*Math.random()),g=c.idPrefix+f;return d.data(c.pluginNameSpace+"id",g),e.prop("id",g),e.attr(c.containerAttrs),e.addClass(c.containerClass),e},e.$spinner=function(){var b=c.spinnerHTML,d=a(b);return d.attr(c.spinnerAttrs),d.addClass(c.spinnerClass),d},(b=function(){var a=e.$container(),b=e.$spinner();a.append(b),a.hide(),d.prepend(a)})()},g.utils=function(b){var e={};return e.getPluginContainerId=function(){var a=d.data(c.pluginNameSpace+"id");return a},e.getPluginContainer=function(){var b=g.utils({action:"getPluginContainerId"}),c=a("#"+b);return c},e.setPluginState=function(){a.fn.ploading.state=b.state},e.getPluginState=function(){return a.fn.ploading.state},e[b.action]()},g.events=function(){var b=g.events,c={"pl:spinner:show":!0,"pl:spinner:hide":!0,"pl:spinner:destroy":!0},d=function(a){return a=a.indexOf(".")===-1?a:a.substring(0,a.indexOf(".")),!c[a]&&(console.error("The event "+a+" doesnt exist"),!0)};b.on=function(b,c){if(!d(b))return a(a.fn.ploading.addOnManager.events).on(b,c)},b.off=function(b,c,d){return a(a.fn.ploading.addOnManager.events).off(b,c,d)},b.trigger=function(b,c){if(!d(b))return a(a.fn.ploading.addOnManager.events).trigger(b,c)}},g.addOnInstaller=function(){var b,e={};e.getAddOns=function(){return a.fn.ploading.addOns},e.getParamsToSend=function(){var a={pluginPublicAction:f,pluginSettings:c,pluginPrivateAction:{utils:g.utils,events:g.events},$pluginElement:d};return a},e.applyAddOnData=function(b){c=a.extend(c,b.pluginSettings),c=a.extend(c,b.pluginPublicAction)},e.installAddOn=function(){var a,b=c.useAddOns.length>0;if(b){a=e.getAddOns();for(var d=0,f=c.useAddOns.length;d<f;d++){var g,h=c.useAddOns[d],i=a[h],j=!!i;j&&(g=e.getParamsToSend(),e.applyAddOnData(i(g)))}}},(b=function(){e.installAddOn()})()},g.changeMaskColor=function(){var b=g.utils({action:"getPluginContainerId"}),d=a("#"+b);d.css("background-color",c.maskColor)}},e.definePublicActions=function(){f.destroy=function(){var a=g.utils({action:"getPluginContainer"});a.remove(),d.removeData(c.pluginNameSpace+"id"),c.onDestroyContainer&&(c.onDestroyContainer(a),d.trigger("pl:spinner:destroy",[a]),g.events.trigger("pl:spinner:destroy"))},f.show=function(){var a=g.utils({action:"getPluginContainer"}),b=0!==a.length;b?c.showAnimation(a,d):(g.buildPluginMarkup(),a=g.utils({action:"getPluginContainer"})),c.showAnimation(a,d),c.maskHolder&&d.addClass("p-loading-element-mask"),c.onShowContainer&&c.onShowContainer(d,a),d.trigger("pl:spinner:show",[d,a]),g.events.trigger("pl:spinner:show")},f.hide=function(){var a=g.utils({action:"getPluginContainer"});c.hideAnimation(a,d),c.maskHolder&&d.removeClass("p-loading-element-mask"),c.onHideContainer&&c.onHideContainer(d,a),d.trigger("pl:spinner:hide",[d,a]),g.events.trigger("pl:spinner:hide"),c.destroyAfterHide&&f.destroy()}},e.runPlublicAction=function(){e.definePluginSettings(),g.events(),g.addOnInstaller(),f[c.action](),g.changeMaskColor(),g.utils({action:"setPluginState",state:"initialized"})},e.initialize=function(){e.definePluginSettings(),e.definePublicVariables(),e.definePrivateActions(),e.definePublicActions(),e.runPlublicAction()},e.initialize(),d},a.fn.ploading.addOns={}}(jQuery);
    </script>
    <script>
      $(function(){
         feather.replace();

         var submitFN=function(){
            $(".sidebar-sticky").ploading({action: 'show'});

            $.post('<?php echo $urlSelf ?>?act=check',$("#checkForm").serialize(),function(d){
                console.log($.parseJSON(d));
                location.reload();
                return false;
            });

            return false;
         };

         $("input").keypress(function(event) {
             if (event.which == 13) {
                 event.preventDefault();
                 submitFN();
             }
         });

         $('#btn-submit').click(submitFN);

         $('#btn-clean').click(function(){
            $("#checkForm").find('input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val("");
            $("#checkForm").find('select').val("No");
            $.get('<?php echo $urlSelf ?>?act=clean');
            return false;
         });

      });
    </script>

  </body>
</html>
