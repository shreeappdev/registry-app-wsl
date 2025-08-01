<html>
<head>
    <title>Registration Letter (Annex-I,Annex-II)</title>
    <style>
        body {
            margin: 0 auto;
            font-size: 13px;
            text-align: justify;
            line-height: 1.5em;

        }

        .fwd {
            text-align: justify;
            width: 683px;
            margin: 0 auto;
        }

        .fwd table {
            width: 100%;
        }

        .letterfwd {
            margin-top: 80%;
        }

        .fwd td {
            width: 40%;
        }

        .anex1,
        .anex2 {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }

        .content-header {
            font-size: 14px;
            font-weight: 600;
        }

        .declare {
            text-align: justify;
        }

        .declare li {
            padding-left: 10px;
        }
    </style>
</head>

<body>
    <div class="fwd">
        <p class="anex1"><strong>Annexure-I</strong></p>
        <p class="content-header"> Authorization Letter to be submitted (On official letter head in the name of Signing Authority only)</p>
        <table>
            <tr>
                <td colspan="4">Domain Name: {{$domain_name}} {{$idn_domain_name}}  </td>
            </tr>
            <tr>
                <td colspan="4">Category of Organisation: <i>{{$orgcategory}}</i></td>
            </tr>
             <tr>
                <td colspan="4">Category of Organisation: <i>{{$organisationName}}</i></td>
            </tr>

            
            <tr>
                <td></td>
            </tr>
        </table>

        <table>
            <tr>

                <td colspan="3"><strong>Organisational Contact (Registrant) Details</strong></td>
            </tr>
            <tr>
                <td colspan="3">Name & Designation: <i>{{$organisationPersonName}}</i></td>
            </tr>
           
            <tr>
                <td colspan="3">Address: <i>{{$organisationAddress}}</i></td>
            </tr>
            <tr>
                <td>City: <i>{{$organisationCity}}</i></td>
                <td>State:<i>{{$organisationState}}</i></td>
                <td>PIN : <i>{{$organisationPincode}}</i></td>
            </tr>
            <tr>
                <td>Telephone: <i>{{$organisationTelephone}}</i></td>
                <td colspan="2">Email: <i>{{$organisationEmail}}</i></td>
            </tr>
            <tr>
                <td></td>
            </tr>
        </table>

        <table>
            <tr>
                <td colspan="3"><strong>Administrative Contact Details</strong></td>
            </tr>
            <tr>
                <td colspan="3">Name & Designation: <i>{{$adminPersonName}}</i></td>
            </tr>
    
            <tr>
                <td colspan="3">Address: <i>{{$adminAddress}}</i></td>
            </tr>
            <tr>
                <td>City: <i>{{$adminCity}}</i></td>
                <td>State: <i>{{$adminState}}</i></td>
                <td>PIN : <i>{{$adminPin}}</i></td>
            </tr>
            <tr>
                <td>Telephone: <i>{{$adminTelephone}}</i></td>
                <td colspan="2">Email: <i>{{$adminEmail}}</i></td>
            </tr>
        </table>

        <div class="declare">
            <strong>Declaration:</strong>
            <ol type="1">
                <li>
                    I as head of the organization acknowledge that <strong><i>{{$organisationName}}</i></strong> meets all
                    requisites to be considered as a government organization and is controlled by the <i>{{$region}}</i>
                    government.
                </li>
                <li>
                    I understand and agree to comply with the following Terms & Conditions of GOV.IN domain
                    registration:-
                    <ol type="a">
                        <li>All the contact addresses entered online and authorization letter are correct and same.</li>
                        <li>The contact details would be updated as and when there is a change.</li>
                        <li>Domain name will not be used for any unlawful and commercial purposes.</li>
                        <li>The web content of the requested domain name will conform to IT Act of India.</li>
                        <li>The domain name would be renewed by sending domain name renewal request in the prescribed
                            format one month prior to the renewal date</li>
                        <li>GOV.IN registry will not be responsible for any false documents submitted, misguidance and
                            any unlawful activities practiced by the registrant using the domain name.</li>
                        <li>GOV.IN allocation will be under the conformity of.IN Domain Name Dispute Resolution Policy
                            (INDRP).</li>
                        <li>Domain shall be canceled in case of information furnished found to be incorrect or
                            misleading or if the GOV.IN guideline is violated.</li>
                        <li>We are aware of the OM of the GoI, MHA, No- 14/4/2001-T dated 17th July 2007 and the website
                            will be hosted in India only</li>
                    </ol>
                </li>
            </ol>
        </div>



        <div class="fwdauth">
            <table>
                <tr>
                    <td colspan="2"><strong>Signing Authority (Organizational Contact (Registrant) Details)</strong>
                    </td>
                </tr>
                <tr>
                    <td>Name & Designation: <i>{{$organisationPersonName}}</i></td>
                    <td>Email: <i>{{$organisationEmail}}</i></td>
                
                </tr>
                <tr>
                    <td>Region:<i>{{$region}}</i></td>
                    <td>Ministry: <i>{{$ministry}}</i></td>                 
                </tr>
                <tr>
                    <td>Department: <i>{{$department}}</i></td>
                    <td>Organisation Name: <i>{{$organisationName}}</i></td>
                </tr>
                <tr>
                    <td>Signature (Seal and date):</td>
                   
                </tr>

            </table>
        </div>
        <p style="text-align:center;">=============================</p>
    </div>
</body>

</html>
