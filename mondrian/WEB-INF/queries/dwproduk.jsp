<%@ page session="true" contentType="text/html; charset=ISO-8859-1" %> <%@ taglib
uri="http://www.tonbeller.com/jpivot" prefix="jp" %> <%@ taglib prefix="c"
uri="http://java.sun.com/jstl/core" %>

<jp:mondrianQuery
  id="query01"
  jdbcDriver="com.mysql.jdbc.Driver"
  jdbcUrl="jdbc:mysql://localhost/dw_uas?user=root&password="
  catalogUri="/WEB-INF/queries/dwproduk.xml"
>
  select {[Measures].[unitprice],[Measures].[Cost],[Measures].[margin]} ON COLUMNS,
  {([culture],[transaction],[time],[produk])} ON ROWS from [cProduk]
</jp:mondrianQuery>

<c:set var="title01" scope="session">Query dwproduk using Mondrian OLAP</c:set>
