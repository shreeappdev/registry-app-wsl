<html>
	<head>
		<title>Subdomain Registrationr</title>
		<style>
			body{
				margin-left: 0px;
				margin-top: 0px;
				margin-right: 0px;
				margin-bottom: 0px;
				font-size:14px;
				font-family:"mangal,Times New Roman",sans-serif;
				text-align: justify;
				line-height: 1.5em;
			}

			.fwd{text-align: justify; width:700px; margin:0 auto;}
			 table{width:100%; border-collapse: collapse;}
			 td,th{border: 1px solid rgb(3, 3, 3); padding: 8px; font-size:14px;}
			.anex1{font-size:13px; font-weight:bold; text-align: center;}

			.declare{text-align: justify;}
			.declare li{padding-left: 10px;}
		</style>
    </head>
    <body>		
        <div class="fwd">
			  <p class="anex1"><strong><u>Subdomain Registration</u></strong></p>			
			  <div class="declare">

					<p>To,
					GOV.IN Domain Name Registrar,<br>
					National Informatics Centre (NIC),<br>
					Ministry of Electronics & Information Technology (MeitY),<br> 
					A-Block, CGO Complex,Lodhi Road,<br>         
					New Delhi - 110 003 <br>  

					<p>Dear Domain Registrar,</p>
					<p>I am the authorized user to register sub-domain(s) under the 3rd level domain <strong>{{ $domainname }}</strong>.
						I formally request you to activate/update the following sub-domain(s) registered online.
					</p>
				<table>

					<tr>
						<th>Sub Domain Name </th>
						<th>Mapped IP / CNAME </th>
					</tr>
					
			        @if($isSameMapping)
                        @if(!empty($subdomainnames) && is_array($subdomainnames))
                            @foreach ($subdomainnames as $subdomain)
                            <tr>
                                <td>{{ $subdomain. '.'. $domainname }} </td>
                                <td>
                                    @if(!empty($cname))
                                    {{ $cname }}
                                    @else
                                        @if(!empty($ips))
                                        <ul>
                                            @foreach ($ips as $ip)
                                            <li>{{ $ip }}</li>	
                                            @endforeach
                                        </ul>
                                        @endif
                                    @endif

                                </td> 
                            </tr>
                            @endforeach                           
                        @endif
                    @else
                        @if(!empty($subdomainnames) && is_array($subdomainnames))
                            @foreach ($subdomainnames as $key => $value)
                            <tr>
                                <td>{{ !empty($value['subdomain']) ? $value['subdomain']. '.'. $domainname : '' }} </td>
                                <td>
                                    @if(!empty($value['cName']))
                                    {{ $value['cName'] }}
                                    @else
                                        @if(!empty($value['ips']))
                                        <ul>
                                            @foreach ($value['ips'] as $ip)
                                            <li>{{ $ip }}</li>	
                                            @endforeach
                                        </ul>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    @endif
					</tr>
					
				</table>
					<p>
						I endorse that the sub-domain name is for a government organization and belongs to the category of the guidelines vide no F.No. 13/14/2014 - IGD dated 23rd October 2019.
						The sub-domain names would be used for official purposes and would conform to the IT Act of India and Aadhaar Act, 2016. Domain name will not be used for any unlawful & commercial purpose and as per MHA OM; the website will be hosted in India only.
					</p>
					<p>Thanks,</p>
					<p><i>Name & Designation</i>: {{ $authorityName }} , {{ $authorityDesg }}</p>
					<p><i>Date</i>: {{ $date }} </p>
					<p><i>Signature</i>:</p>
		      </div>
				<p style="text-align:center;">=============================</p>			
		</div>
	</body>
</html>
