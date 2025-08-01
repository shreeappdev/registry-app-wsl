<html>
	<head>
		<title>Authorization Letter - Forwarding Authority</title>
		<style>
			    body{
					margin:0 auto;
					font-size:13px;
					text-align: justify;
					line-height: 1.5em;
			
				}
				.letterfwd{margin-top:10%;}
				.anex2{font-weight:bold; text-align: center;}
				.content-header{font-weight:600; }
		</style>
	</head>
	<body>
            
			    <div class="letterfwd">
					<p class="anex2"><strong>Annexure-II</strong></p>
					<p class="content-header"><span>Forwarding Letter</span> to be submitted (On official letter head in the name of Signing Authority only)</p>
					<p>To<br/>
					The GOV.IN Domain Name Registrar<br/>
					Gov.in Registry<br/>
					National Informatics Centre (NIC)<br/>
					Ministry of Electronics & Information Technology <br/>
					A-Block, CGO Complex, Lodhi Road<br/>
					New Delhi - 110 003<br/>
					</p>
					<p><strong>Subject:</strong> "Regarding registration of domain name {{$domain_name}}  {{$idn_domain_name}}".</p>
					<p>I am hereby forwarding the Authorization Letter for the domain '{{$domain_name}} {{$idn_domain_name}}' and  confirm that all information furnished in the Authorization Letter is correct to the best of my knowledge.</p>
					<p>I <i>{{$nodal_name}},{{$nodal_designation}}</i>  <strong>{{$ministry_dept_org_name}}</strong> endorse that the <strong>{{$organisationName}}</strong> is a government organization and belongs to the category <b>{{$orgcategory}}</b> of the guidelines vide no F.No. 13/14/2014-IGD dated 23<sup>th</sup> October 2019.  The domain name '{{$domain_name}} {{$idn_domain_name}}' would be used for official purposes and would conform to the IT Act of India and Aadhaar Act, 2016. Domain name will not be used for any unlawful & commercial purpose and as per MHA OM, the website will be hosted in India only.</p>
					
					{{$contentforenglish}}
					<p>Hence, I recommend {{$domain_name}} {{$idn_domain_name}} for <strong>{{$organisationName}}</strong>.</p><p><strong><u>Signing Authority</u></strong></p>

				
						<table class="fwd">
								<tr>
									<td >Name: <i>{{$nodal_name}}</i></td>
									<td>Designation: <i>{{$nodal_designation}}</i></td>
								</tr>
								<tr>
									<td>Email: <i>{{$nodal_email}}</i></td>
								</tr>
								<tr>
									<td>Ministry: <i>{{$nodal_ministry}}</i></td>
									<td>Region: <i>{{$nodal_region}}</i></td>	
								</tr>
								<tr>
									<td>Department: <i>{{$nodal_dept}}</i></td>
									<td>Organisation: <i>{{$nodal_organisation}}</i></td>
								</tr>
								<tr>
									
									<td>Signature (seal and date):</td>
									<td>Date: <i></i></td>
								</tr>
								
						</table>
                </div>					
			   <br/><br/>
		   <p style="text-align:center;">=============================</p>			
		</body>
</html>
