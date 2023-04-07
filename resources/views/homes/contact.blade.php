@extends('home')
@section('title', 'Contact')
@section('content')

        <!-- firsthead-->
        <div class=" clearfix"></div>
            <div class="container about shadow ">
                <h6 class="text-center rounded p-2">Contact Us</h6><hr>
                    <div class="row  pt-2">
                        <div class="col ">
                            <div class="pt-6 rounded">
                                <h6 class=" text-warning">Facebook Page Support(24/7)</h6><br>
                                <a class="a  rounded p-2" href="https://www.facebook.com/dolightjob" target="blank">www.facebook.com/dolightjob</a>
                            </div>
                            <div class="pt-6 rounded">
                                <h6 class=" text-warning">Messenger Support(24/7)</h6><br>
                                <a class="a rounded p-2" href="https://business.facebook.com/latest/inbox/messenger?asset_id=101580072230111&nav_ref=pages_classic_isolated_section_inbox_redirect&mailbox_id=&selected_item_id=100069612794572" target="blank">facebook.com/messenger</a>
                            </div>
                        </div>
                        <div class="col ">
                            <div class="pt-6 rounded">
                                <h6 class=" text-warning">You Tube Support (24/7)</h6><br>
                                <a class="a  rounded p-2" href="https://www.youtube.com/channel/UC54uPc0r5wR9VHn5fTBLw9w?sub_confirmation=1" target="blank">https://www.youtube.com</a>
                            </div>
                            <div class="pt-6 rounded">  
                                <h6 class=" text-warning">Live Phone/ Call Support (24/7)</h6><br>
                                <!--new code here-->
                                <div class="form-group">
                                    <input type="text" name="" value="01784888730" id="copyText">
                                    <button class="btn btn-primary cp" onclick="clipboard('copy')">copy</button>
                                </div>
                                <!--End code here-->
                            </div>
                        </div>
                    </div>
            </div>
        <div class=" clearfix2"></div>

@endsection