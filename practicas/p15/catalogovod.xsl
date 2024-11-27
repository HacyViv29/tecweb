<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html" encoding="UTF-8" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN" doctype-system="http://www.w3.org/TR/xhtml1/DTD/strict.dtd" />
    
    <xsl:template match="/">
        <html>
            <head>
                <title>Catálogo VOD</title>
                <style>
                    .top-section {
                        background-color: #101010;
                        width: 100%;
                    }

                    body {
                        margin: 0%;
                        font-family: Arial, sans-serif;
                        font-size: 16px;
                        background-color: #0F171E;
                        color: #FFFFFF;
                    }
                    
                    h1 {
                        color: #00A8E1;
                        text-align: center;
                        padding: 20px;
                        background-color: #232F3E;
                        margin: 0;
                    }
                    
                    .logo {
                        text-align: center;
                        margin-bottom: 20px;
                    }
                    
                    table {
                        width: 80%;
                        margin: 20px auto;
                        border-collapse: collapse;
                        border: 1px solid #FFFFFF;
                    }
                    
                    td {
                        border: 1px solid #CCCCCC;
                        padding: 10px;
                        text-align: left;
                    }
                    
                    th {
                        background-color: #232F3E;
                        color: #FFFFFF;
                        padding: 10px;
                    }
                    
                    caption {
                        font-size: 1.5em;
                        margin: 15px 0;
                        color: #00A8E1;
                        font-weight: bold;
                    }
                    
                </style>
            </head>

            <body>
                <!-- Logotipo -->
                <div class="top-section">
                    <div class="logo">
                        <img src="PrimeLogo.png" alt="Logotipo de Prime Video" width="20%" height="10%" />
                    </div>

                <!-- Título -->
                    <h1>Catálogo Video On Demand</h1>
                </div>

                <!-- Usuarios -->
                <table>
                    <caption>USUARIOS</caption>
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Correo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Iterar por cada cuenta -->
                        <xsl:for-each select="//cuenta">
                            <!-- Primer usuario de la cuenta -->
                            <xsl:for-each select="perfiles/perfil[1]">
                                <tr>
                                    <td><xsl:value-of select="@usuario" /></td>
                                    <td rowspan="{count(../perfil)}">
                                        <xsl:value-of select="../..//@correo" />
                                    </td>
                                </tr>
                            </xsl:for-each>

                            <!-- Usuarios adicionales de la cuenta -->
                            <xsl:for-each select="perfiles/perfil[position() &gt; 1]">
                                <tr>
                                    <td><xsl:value-of select="@usuario" /></td>
                                </tr>
                            </xsl:for-each>
                        </xsl:for-each>
                    </tbody>
                </table>
                
                <!-- Películas -->
                <table>
                    <caption>PELÍCULAS</caption>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Duración</th>
                            <th>Género</th>
                        </tr>
                    </thead>
                    <tbody>
                        <xsl:for-each select="//contenido/peliculas/genero/titulo">
                            <tr>
                                <td><xsl:value-of select="." /></td>
                                <td><xsl:value-of select="@duracion" /></td>
                                <td><xsl:value-of select="../@nombre" /></td>
                            </tr>
                        </xsl:for-each>
                    </tbody>
                </table>

                <!-- Series -->
                <table>
                    <caption>SERIES</caption>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Duración</th>
                            <th>Género</th>
                        </tr>
                    </thead>
                    <tbody>
                        <xsl:for-each select="//contenido/series/genero/titulo">
                            <tr>
                                <td><xsl:value-of select="." /></td>
                                <td><xsl:value-of select="@duracion" /></td>
                                <td><xsl:value-of select="../@nombre" /></td>
                            </tr>
                        </xsl:for-each>
                    </tbody>
                </table>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
