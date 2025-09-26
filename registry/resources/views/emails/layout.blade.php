<table cellspacing="0" style="width: 520px; margin: auto; margin-top:20px;font-family: 'Times New Roman', Times, serif; padding: 0px;">

    <tr style="background-color: #5877e7; height: 60px;">
        <th colspan="3" style="text-align: left">
            <img src="{{ asset('images/gov.in.png') }}" height="55px">
        </th>
    </tr>

    <tr style="border: 2px solid #5877e7; background-color: #ececec;">
        <td colspan="3" style="padding: 20px 15px; border: 10px solid lightgrey;margin:10px; line-height: 25px;background-color: white; font-size:14px; text-align: left;">
            Dear Sir/Madam,
            <br><br>

            {{-- Injected Content Here --}}
            {!! $content !!}

            <br><br>
            Regards, <br>
            GOV.IN Domain Registrar<br>
            National Informatics Centre (<a href="https://www.nic.in/">NIC</a>)<br>
            A-Block, CGO Complex, Lodhi Road<br> 
            New Delhi - 110003 <br>
            Contact Us - <a href="http://servicedesk.nic.in">servicedesk.nic.in</a> <br>
            Contact No - 1800-111-555 <br>
        </td>
    </tr>

    <tr style="background-color: #42566c;height:70px; font-size:0.6em; align-items: center; justify-content: center; color: white;text-align: center; width: 520px;">
        <td colspan="1" style="padding: 15px 10px 15px 10px;">
            <img src="{{ asset('images/nic-logo.png') }}" width="165" style="padding: 15px 10px 15px 0;font-size: 12px;">
        </td>
        <td colspan="2" style="padding: 15px 10px 15px 0px;font-size: 12px;">
            Website Designed, Developed, Hosted and Maintained by<br>
            National Informatics Centre (NIC)<br>
            Ministry of Electronics and Information Technology (MeitY)<br>
            Government of India
        </td>
    </tr>
</table>
