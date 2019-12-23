<?php

interface IConnectInfo
{
    const HOST ="localhost";
    const UNAME ="homestead";
    const DBNAME = "upload";
    const PW = "secret";
    function getConnection();
}
