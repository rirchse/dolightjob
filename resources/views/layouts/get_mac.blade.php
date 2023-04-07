<script type="text/javascript">

    var macAddress = "";
    var user_address_ip = "";
    var your_computernm = "ChalanBeel";
    var wmi = GetObject("winmgmts:{impersonationLevel=impersonate}");
    e = new Enumerator(wmi.ExecQuery("SELECT * FROM Win32_NetworkAdapterConfiguration WHERE IPEnabled = True"));
    for(; !e.atEnd(); e.moveNext()) {
        var s = e.item();
        macAddress = s.MACAddress;
        user_address_ip = s.IPAddress(0);
        your_computernm = s.DNSHostName;
    }

    console.log(your_computernm);


</script>