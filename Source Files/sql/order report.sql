select s.number,s.date,p.`name`
,i.finalPriceWithVAT,i.amount,i.`rowTotal`,
p.`categoryName`,s.`clientName`, s.address,p.nameCN,i.price,i.`rowNetTotal`,i.finalNetPrice,i.`rowVAT`
from `sales_documents` s, `sales_document_items` i, `products` p
where s.`salesDocumentID`=i.`salesDocumentID` and i.`productID`=p.`productID` and p.`supplierID`=4884;