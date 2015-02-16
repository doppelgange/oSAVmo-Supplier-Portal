INSERT INTO supplier_sales_documents
(supplierID, salesDocumentID, amount, netTotal, vatTotal,total,lastModified,lastModifierUsername,created_at,updated_at)
select prod.supplierID, doc.salesDocumentID, @amount := sum(item.amount), @rowNetTotal := sum(item.rowNetTotal), @rowVat := sum(item.rowVat), @rowTotal := sum(item.rowTotal),NOW(),'System',NOW(),NOW()
from sales_documents doc, sales_document_items item, products prod
where doc.salesDocumentID = item.salesDocumentID and item.productID = prod.productID group by doc.salesDocumentID,prod.supplierID
on duplicate key update 
amount = @amount, 
netTotal = @rowNetTotal, 
vatTotal = @rowVat,
total = @rowTotal,
lastModified = NOW(),
lastModifierUsername = "System",
updated_at = NOW();


truncate supplier_sales_documents;
truncate sales_documents;
truncate sales_document_items;





INSERT INTO supplier_sales_documents (supplierID, salesDocumentID, amount, netTotal, vatTotal,total,lastModified,lastModifierUsername,created_at,updated_at) select prod.supplierID, doc.salesDocumentID, @amount := sum(item.amount), @rowNetTotal := sum(item.rowNetTotal), @rowVat := sum(item.rowVat), @rowTotal := sum(item.rowTotal),NOW(),"System",NOW(),NOW() from sales_documents doc, sales_document_items item, products prod where doc.salesDocumentID = item.salesDocumentID and item.productID = prod.productID group by doc.salesDocumentID,prod.supplierID on duplicate key update amount = @amount, netTotal = @rowNetTotal, vatTotal = @rowVat,total = @rowTotal,lastModified = NOW(),lastModifierUsername = "System",updated_at = NOW();