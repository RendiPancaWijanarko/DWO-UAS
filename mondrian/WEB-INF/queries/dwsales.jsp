<%@ page session="true" contentType="text/html; charset=ISO-8859-1" %> <%@ taglib
uri="http://www.tonbeller.com/jpivot" prefix="jp" %> <%@ taglib prefix="c"
uri="http://java.sun.com/jstl/core" %>

<jp:mondrianQuery
  id="query01"
  jdbcDriver="com.mysql.jdbc.Driver"
  jdbcUrl="jdbc:mysql://localhost/dw_uas?user=root&password="
  catalogUri="/WEB-INF/queries/dwsales.xml"
>
  select { [Measures].[commission], [Measures].[tax], [Measures].[freight], [Measures].[totaldue],
  [Measures].[subtotal], [Measures].[TotalProfit] } ON COLUMNS, { ( [loc], [time], [produk], [sales]
  ) } ON ROWS from [cSales]
</jp:mondrianQuery>

<c:set var="title01" scope="session">Query dwuas using Mondrian OLAP</c:set>
