insert into `price_list_items` (`deliveryTypeID`, `code`, `name`, `added`, `lastModified`, `updated_at`, `created_at`) values (2, 'UCMPTED', 'Uncompleted', 1409561330, 0, '2015-02-12 13:10:17', '2015-02-12 13:10:17');


select doc.salesDocumentID, prod.productID,  from salesDocument doc, salesDocumentItems item, products prod where doc.salesDocumentID = item.salesDocumentID and item.productID = prod.productID group BY doc.salesDocumentID, prod.productID;