<!--
Author     : Jaren Yeap Wei Loon
Student ID : 19WMR09599 
-->
<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:template match="/">
        <html>
            <head>
                <title>User Profile</title>
            </head>
            <body>
                <h1>User Profile</h1>
                <hr />
                <xsl:apply-templates/>
                <br/><br/><input type="submit" name="out" value="LogOut" onclick="location.href='http://localhost/Assignment/UI/Login.php';"/>
            </body>
        </html>
    </xsl:template>
    <xsl:template match="user[@type='Customer']">
        <p>Customer ID: <xsl:value-of select="id"/></p>
        <table border="1">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>DateOfBirth</th>
                <th>HomeAddress</th>    
            </tr>
                <tr>
                    <td><xsl:value-of select="name"/></td>
                    <td><xsl:value-of select="email"/></td>
                    <td><xsl:value-of select="password"/></td>
                    <td><xsl:value-of select="dob"/></td>                    
                    <td><xsl:value-of select="address"/></td>
                </tr>
        </table>
        <!--change address accordingly-->
        <br/><input type="submit" name="order" value="Order Page" onclick="location.href='http://localhost/Assignment/UI/OrderCustomer.php';"/>
        <input type="submit" name="ship" value="Track Parcel" onclick="location.href='http://localhost/Assignment/UI/ShippingCustomer.php';"/>
    </xsl:template>
    <xsl:template match="user[@type='Staff']">
        <p>Staff ID: <xsl:value-of select="id"/></p>
        <table border="1">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Position</th> 
            </tr>
                <tr>
                    <td><xsl:value-of select="name"/></td>
                    <td><xsl:value-of select="email"/></td>
                    <td><xsl:value-of select="password"/></td>
                    <td><xsl:value-of select="position"/></td>  
                </tr>
        </table>
        <!--change address accordingly-->
        <br/><input type="submit" name="stock" value="Stock Management" onclick="location.href='http://localhost/Assignment/UI/StockManage.php';"/>
        <input type="submit" name="Sship" value="Manage Shipment" onclick="location.href='http://localhost/Assignment/UI/ShippingStaff.php';"/>
    </xsl:template>
</xsl:stylesheet>
