/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package ReportHoaDon;


import java.awt.Desktop;
import java.io.File;
import java.sql.Connection;
import java.sql.DriverManager;
import java.util.HashMap;
import java.util.Map;
import javax.swing.JFrame;
import net.sf.jasperreports.engine.JRExporterParameter;
import net.sf.jasperreports.engine.JasperCompileManager;
import net.sf.jasperreports.engine.JasperReport;
import net.sf.jasperreports.engine.JasperExportManager;
import net.sf.jasperreports.engine.JasperPrint;
import net.sf.jasperreports.engine.JasperFillManager;
import net.sf.jasperreports.engine.design.JasperDesign;
import net.sf.jasperreports.engine.export.JRPdfExporter;
import net.sf.jasperreports.engine.xml.JRXmlLoader;
import net.sf.jasperreports.view.JasperViewer;


/**
 *
 * @author Aki
 */
public class ReportHoaDon extends JFrame{
  /*  public  static Connection Con(){
         String drive ="com.microsoft.sqlserver.jdbc.SQLServerDriver";
    String urdb="jdbc:sqlserver://127.0.0.1:2015;databaseName=QLshopquanao";
    String user="sa";
    String pass="123";
    Connection con=null;
        try {
             Class.forName(drive);
              con=DriverManager.getConnection(urdb,user,pass);
        } catch (Exception e) {e.printStackTrace();
        }
        return con;
    }
  public void getReportOrderDetail(int id,String tenkh,String payment){
      try {
          Map hashMap= new HashMap();
          hashMap.put("TenKH","tenkh" );
          hashMap.put("Pay_method", "payment");
          hashMap.put("UserID", "id");
          JasperPrint print =JasperFillManager.fillReport(inputStream, hashMap)
         // JasperDesign design=JRXmlLoader.load("src/ReportHoaDon/report1.jrxml");
          //JasperReport report=JasperCompileManager.compileReport(design);
          //JasperPrint print=JasperFillManager.fillReport(report, hashMap,Con());
          //File file= new File("C:\\Hoa don"+UserID+".pdf");
         // JRPdfExporter export = new JRPdfExporter();
          //export.setParameter(JRExporterParameter.JASPER_PRINT, print);
          //export.setParameter(JRExporterParameter.OUTPUT_FILE, file);
          //Desktop desk= Desktop.getDesktop();
          //desk.open(file);
      } catch (Exception e) {
      e.printStackTrace();}
  }
    */
    public ReportHoaDon(int id){
        try {
            
              String drive ="com.microsoft.sqlserver.jdbc.SQLServerDriver";
            String urdb="jdbc:sqlserver://127.0.0.1:2015;databaseName=QLshopquanao";
            String user="sa";
            String pass="123";
            Connection con=null;
        
             Class.forName(drive);
              con=DriverManager.getConnection(urdb,user,pass);
              
       
              JasperReport jr= JasperCompileManager.compileReport("src\\ReportHoaDon\\report1.jrxml");
              
              HashMap hashMap= new HashMap();
              hashMap.put("UserID", id);
             
              
              JasperPrint jp=JasperFillManager.fillReport(jr, hashMap,con);
              
            JasperViewer.viewReport(jp);
              
              
              //JasperPrint print=JasperFillManager.fillReport("src/ReportHoaDon/report1.jasper", hashMap,con);
              
              
        } catch (Exception e) {
        }
        
    }
    
}
