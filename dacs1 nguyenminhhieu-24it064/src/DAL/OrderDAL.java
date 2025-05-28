/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package DAL;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.ArrayList;
import Entity.Order;

/**
 *
 * @author Aki
 */
public class OrderDAL extends DataAcessHelper{
    
    private final String GET_ALL="select * from OrderKH";
    private final String ADD_DATA ="insert into OrderKH(OrderID,Date,Name,UserID,Price) values(?,?,?,?,?)";
    private final String REMOVE_DATA="Delete from OrderKH where OrderID=?";
    private final String UPDATE_DATA="Update OrderKH set Date=?,Name=?,UserID=?,Price=? where OrderID=?";
    
   
    public ArrayList<Order> getAll()
    {
        ArrayList<Order> objs = new ArrayList<>();
        try {
            getConnect();
            PreparedStatement ps = con.prepareStatement(GET_ALL);
            ResultSet rs = ps.executeQuery();
            if(rs!=null)
            {
                while(rs.next())
                {
                    Order item = new Order();
                    item.setOrderID(rs.getInt("OrderID"));
                    item.setDate(rs.getString("Date"));
                    item.setName(rs.getString("Name"));
               
                
                    item.setUserID(rs.getInt("UserID"));
  
                    item.setPrice(rs.getInt("Price"));
                    objs.add(item);
                }
                }
            getClose();
        } catch (Exception e) {e.printStackTrace();
        }
        return objs;
    }
    public boolean AddData(Order ord)
    {
        boolean check = false;
        try{
            getConnect();
            PreparedStatement ps = con.prepareStatement(ADD_DATA);
            ps.setInt(1, ord.getOrderID());
            ps.setString(2, ord.getDate());
            ps.setString(3, ord.getName());
    
     
            ps.setInt(4, ord.getUserID());
            ps.setInt(5, ord.getPrice());
            int rs=ps.executeUpdate();
            if(rs>0){
                check=true;
            }
            getClose();
        }catch(Exception e){
            e.printStackTrace();
        }
        return check;
    }
    public boolean DeleteData(int u){
        boolean check= false;
        try{
            getConnect();
            PreparedStatement ps = con.prepareStatement(REMOVE_DATA);
            ps.setInt(1, u);
            int rs=ps.executeUpdate();
            if(rs>0)
            {
                check=true;
            }
        }catch(Exception e){
         e.printStackTrace();
        }
        return check;
    }
     public boolean UpdateData(Order ord)
    {
        boolean check = false;
        try{
            getConnect();
            PreparedStatement ps = con.prepareStatement(UPDATE_DATA);
            //
            ps.setString(1, ord.getDate());
            ps.setString(2, ord.getName());
    
      
            ps.setInt(3, ord.getUserID());

            ps.setInt(4, ord.getPrice());
            ps.setInt(5, ord.getOrderID());
            int rs=ps.executeUpdate();
            if(rs>0){
                check=true;
            }
            getClose();
        }catch(Exception e){
            e.printStackTrace();
        }
        return check;
    }
    
    
}
