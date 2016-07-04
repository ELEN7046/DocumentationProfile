SELECT m.* 
INTO tbl_7046DocumentationNeedsSummary
FROM 
(
select year(CaptureDate) as CaptureYear,main.Province,main.District,main.LocalMunicipality,main.AssistWithBirthCertificate as DocNeed,
bcs.TotalsBC,dcs.TotalsDC,pps.TotalsPP,rps.TotalsRP,mcs.TotalsMC,ids.TotalsID,
(bcs.TotalsBC + dcs.TotalsDC + pps.TotalsPP + rps.TotalsRP + mcs.TotalsMC + ids.TotalsID) as TotalDocNeeds

from [dbo].Wop_Vw_v2011Extract_HouseholdMemberSelectionsAndNeeds main,
(select  year(CaptureDate) as CaptureYear,ProvinceId,DistrictMunicipalityId,LocalMunicipalityId,AssistWithBirthCertificate, count(AssistWithBirthCertificate) as TotalsBC
from [dbo].Wop_Vw_v2011Extract_HouseholdMemberSelectionsAndNeeds
--where year(CaptureDate) =2013
group by year(CaptureDate), ProvinceId,DistrictMunicipalityId,LocalMunicipalityId,AssistWithBirthCertificate) bcs,

(select  year(CaptureDate) as CaptureYear,ProvinceId,DistrictMunicipalityId,LocalMunicipalityId,AssistWithIdentityDocument, count(AssistWithIdentityDocument) as TotalsID
from [dbo].Wop_Vw_v2011Extract_HouseholdMemberSelectionsAndNeeds
--where year(CaptureDate) =2013
group by year(CaptureDate), ProvinceId,DistrictMunicipalityId,LocalMunicipalityId,AssistWithIdentityDocument) ids,

(select  year(CaptureDate) as CaptureYear,ProvinceId,DistrictMunicipalityId,LocalMunicipalityId,AssistWithDeathCertificate, count(AssistWithDeathCertificate) as TotalsDC
from [dbo].Wop_Vw_v2011Extract_HouseholdMemberSelectionsAndNeeds
--where year(CaptureDate) =2013
group by year(CaptureDate), ProvinceId,DistrictMunicipalityId,LocalMunicipalityId,AssistWithDeathCertificate) dcs,

(select  year(CaptureDate) as CaptureYear,ProvinceId,DistrictMunicipalityId,LocalMunicipalityId,AssistWithPassport, count(AssistWithPassport) as TotalsPP
from [dbo].Wop_Vw_v2011Extract_HouseholdMemberSelectionsAndNeeds
--where year(CaptureDate) =2013
group by year(CaptureDate), ProvinceId,DistrictMunicipalityId,LocalMunicipalityId,AssistWithPassport) pps,

(select  year(CaptureDate) as CaptureYear,ProvinceId,DistrictMunicipalityId,LocalMunicipalityId,AssistWithResidentPermit, count(AssistWithResidentPermit) as TotalsRP
from [dbo].Wop_Vw_v2011Extract_HouseholdMemberSelectionsAndNeeds
--where year(CaptureDate) =2013
group by year(CaptureDate), ProvinceId,DistrictMunicipalityId,LocalMunicipalityId,AssistWithResidentPermit) rps,

(select  year(CaptureDate) as CaptureYear,ProvinceId,DistrictMunicipalityId,LocalMunicipalityId,AssistWithMarriageCertificate, count(AssistWithMarriageCertificate) as TotalsMC
from [dbo].Wop_Vw_v2011Extract_HouseholdMemberSelectionsAndNeeds
--where year(CaptureDate) =2013
group by year(CaptureDate), ProvinceId,DistrictMunicipalityId,LocalMunicipalityId,AssistWithMarriageCertificate) mcs

where bcs.CaptureYear = year(CaptureDate)
and ids.CaptureYear = year(CaptureDate)
and mcs.CaptureYear = year(CaptureDate)
and pps.CaptureYear = year(CaptureDate)
and rps.CaptureYear = year(CaptureDate)
and dcs.CaptureYear = year(CaptureDate)

and bcs.AssistWithBirthCertificate = main.AssistWithBirthCertificate
and ids.AssistWithIdentityDocument = main.AssistWithIdentityDocument
and mcs.AssistWithMarriageCertificate = main.AssistWithMarriageCertificate
and pps.AssistWithPassport = main.AssistWithPassport
and rps.AssistWithResidentPermit = main.AssistWithResidentPermit
and dcs.AssistWithDeathCertificate = main.AssistWithDeathCertificate

and bcs.AssistWithBirthCertificate = ids.AssistWithIdentityDocument
and bcs.AssistWithBirthCertificate = mcs.AssistWithMarriageCertificate
and bcs.AssistWithBirthCertificate = pps.AssistWithPassport
and bcs.AssistWithBirthCertificate = rps.AssistWithResidentPermit
and bcs.AssistWithBirthCertificate = dcs.AssistWithDeathCertificate

and bcs.ProvinceId = main.ProvinceId
and ids.ProvinceId = main.ProvinceId
and mcs.ProvinceId = main.ProvinceId
and pps.ProvinceId = main.ProvinceId
and rps.ProvinceId = main.ProvinceId
and dcs.ProvinceId = main.ProvinceId

and bcs.ProvinceId = ids.ProvinceId
and bcs.ProvinceId = mcs.ProvinceId
and bcs.ProvinceId = pps.ProvinceId
and bcs.ProvinceId = rps.ProvinceId
and bcs.ProvinceId = dcs.ProvinceId

and bcs.DistrictMunicipalityId = main.DistrictMunicipalityId
and ids.DistrictMunicipalityId = main.DistrictMunicipalityId
and mcs.DistrictMunicipalityId = main.DistrictMunicipalityId
and pps.DistrictMunicipalityId = main.DistrictMunicipalityId
and rps.DistrictMunicipalityId = main.DistrictMunicipalityId
and dcs.DistrictMunicipalityId = main.DistrictMunicipalityId

and bcs.DistrictMunicipalityId = ids.DistrictMunicipalityId
and bcs.DistrictMunicipalityId = mcs.DistrictMunicipalityId
and bcs.DistrictMunicipalityId = pps.DistrictMunicipalityId
and bcs.DistrictMunicipalityId = rps.DistrictMunicipalityId
and bcs.DistrictMunicipalityId = dcs.DistrictMunicipalityId
and bcs.DistrictMunicipalityId = ids.DistrictMunicipalityId

and bcs.LocalMunicipalityId = main.LocalMunicipalityId
and ids.LocalMunicipalityId = main.LocalMunicipalityId
and mcs.LocalMunicipalityId = main.LocalMunicipalityId
and pps.LocalMunicipalityId = main.LocalMunicipalityId
and rps.LocalMunicipalityId = main.LocalMunicipalityId
and dcs.LocalMunicipalityId = main.LocalMunicipalityId

and bcs.LocalMunicipalityId = ids.LocalMunicipalityId
and bcs.LocalMunicipalityId = mcs.LocalMunicipalityId
and bcs.LocalMunicipalityId = pps.LocalMunicipalityId
and bcs.LocalMunicipalityId = rps.LocalMunicipalityId
and bcs.LocalMunicipalityId = dcs.LocalMunicipalityId
and bcs.LocalMunicipalityId = ids.LocalMunicipalityId


group by year(CaptureDate),main.Province,main.District,main.LocalMunicipality,main.AssistWithBirthCertificate,main.AssistWithIdentityDocument,
bcs.TotalsBC,ids.TotalsID,dcs.TotalsDC,mcs.TotalsMC,pps.TotalsPP,rps.TotalsRP
) m
--order by 1,2,3,4


---------------------------------------------------------------------------------------------------------
WORKING - Final version

select year(CaptureDate) as CaptureYear,main.Province,main.District,main.LocalMunicipality,main.AssistWithBirthCertificate as DocNeed,
bcs.TotalsBC,dcs.TotalsDC,pps.TotalsPP, rps.TotalsRP,mcs.TotalsMC,ids.TotalsID,(bcs.TotalsBC + dcs.TotalsDC + pps.TotalsPP + rps.TotalsRP + mcs.TotalsMC +ids.TotalsID) as TotalDocNeeds/*,pps.TotalsPP,rps.TotalsRP,mcs.TotalsMC,ids.TotalsID,
(bcs.TotalsBC + dcs.TotalsDC + pps.TotalsPP + rps.TotalsRP + mcs.TotalsMC + ids.TotalsID)*/

from [dbo].[tbl_7046ProvinceDistrictLocalDocumentationNeeds] main

inner join [dbo].[vw_7046ProvinceDistrictLocalBirthCertificateNeeds] bcs 
on bcs.CaptureYear = year(CaptureDate)
inner join [dbo].[vw_7046ProvinceDistrictLocalDeathCertificateNeeds] dcs 
on dcs.CaptureYear = bcs.CaptureYear
inner join [dbo].vw_7046ProvinceDistrictLocalPassportNeeds pps 
on pps.CaptureYear = bcs.CaptureYear
inner join [dbo].[vw_7046ProvinceDistrictLocalResidentPermitNeeds] rps
on rps.CaptureYear = bcs.CaptureYear
inner join [dbo].[vw_7046ProvinceDistrictLocalMarriageCertificateNeeds] mcs 
on mcs.CaptureYear = bcs.CaptureYear
inner join [dbo].[vw_7046ProvinceDistrictLocalIdentityDocumentNeeds] ids 
on bcs.CaptureYear = ids.CaptureYear

and main.ProvinceID =bcs.ProvinceID
and dcs.ProvinceID = bcs.ProvinceID
and pps.ProvinceID = bcs.ProvinceID
and rps.ProvinceID = bcs.ProvinceID
and mcs.ProvinceID = bcs.ProvinceID
and ids.ProvinceID = bcs.ProvinceID

and bcs.DistrictMunicipalityId = main.DistrictMunicipalityId
and dcs.DistrictMunicipalityId = bcs.DistrictMunicipalityId
and pps.DistrictMunicipalityId = bcs.DistrictMunicipalityId
and rps.DistrictMunicipalityId = bcs.DistrictMunicipalityId
and mcs.DistrictMunicipalityId = bcs.DistrictMunicipalityId
and ids.DistrictMunicipalityId = bcs.DistrictMunicipalityId

and bcs.LocalMunicipalityId = main.LocalMunicipalityId
and dcs.LocalMunicipalityId = bcs.LocalMunicipalityId
and pps.LocalMunicipalityId = bcs.LocalMunicipalityId
and rps.LocalMunicipalityId = bcs.LocalMunicipalityId
and mcs.LocalMunicipalityId = bcs.LocalMunicipalityId
and ids.LocalMunicipalityId = bcs.LocalMunicipalityId

and bcs.AssistWithBirthCertificate = main.AssistWithBirthCertificate
and dcs.AssistWithDeathCertificate = bcs.AssistWithBirthCertificate
and pps.AssistWithPassport = bcs.AssistWithBirthCertificate
and rps.AssistWithResidentPermit = bcs.AssistWithBirthCertificate
and mcs.AssistWithMarriageCertificate = bcs.AssistWithBirthCertificate
and ids.AssistWithIdentityDocument = bcs.AssistWithBirthCertificate

group by year(CaptureDate),main.Province,main.District,main.LocalMunicipality,main.AssistWithBirthCertificate,bcs.TotalsBC,ids.TotalsID,dcs.TotalsDC,pps.TotalsPP,rps.TotalsRP,mcs.TotalsMC
) m
--order by 1,2,3,4

