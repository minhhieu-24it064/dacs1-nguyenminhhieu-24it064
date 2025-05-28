/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package DAL;

import Entity.OrderDetail;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.ArrayList;

/**
 *
 * @author Aki
 */
public class OrderDetailDAL extends DataAcessHelper{
    private final String GET_ALL="select * from OrderDetailID";
    private final String ADD_DATA ="insert into OrderDetailID(OrderDetailID,Date,UserID,ProductID,Quantity,Price,Payment_method,OrderID) values(?,?,?,?,?,?,?,?)";
    private final String REMOVE_DATA="Delete from OrderDetailID where OrderDetailID=?";
    private final String UPDATE_DATA="Update OrderDetailID set Date=?,UserID=?,ProductID=?,Quantity=?,Price=?,Payment_method=?,OrderID=? where OrderDetailID=?";
    private final String GET_DATA_PAYMENT="select * from OrderDetailID where OrderDetailID=? ";
    
     public ArrayList<OrderDetail> getAll()
    {
        ArrayList<OrderDetail> objs = new ArrayList<>();
        try {
            getConnect();
            PreparedStatement ps = con.prepareStatement(GET_ALL);
            ResultSet rs = ps.executeQuery();
            if(rs!=null)
            {
                while(rs.next())
                {
                    OrderDetail item = new OrderDetail();
                    item.setOrderDetailId(rs.getInt("OrderDetailID"));
                    item.setDate(rs.getString("Date"));
                    item.setUserID(rs.getInt("UserID"));
                    item.setProductID(rs.getInt("ProductID"));
                    item.setQuantity(rs.getInt("Quantity"));
                    item.setPrice(rs.getInt("Price"));
                    item.setPayment_method(rs.getString("Payment_method"));
                    item.setOrderID(rs.getInt("OrderID"));
                    objs.add(item);
                }
                }
            getClose();
        } catch (Exception e) {
        e.printStackTrace();
                }
        return objs;
    }
    public boolean AddData(OrderDetail orde)
    {
        boolean check = false;
        try{
            getConnect();
            PreparedStatement ps = con.prepareStatement(ADD_DATA);
            ps.setInt(1, orde.getOrderDetailId());
            ps.setString(2, orde.getDate());
            ps.setInt(3, orde.getUserID());
            ps.setInt(4, orde.getProductID());
            ps.setInt(5, orde.getQuantity());
            ps.setInt(6, orde.getPrice());
            ps.setString(7, orde.getPayment_method());
            ps.setInt(8, orde.getOrderID());
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
    public boolean DeleteData(int id){
        boolean check= false;
        try{
            getConnect();
            PreparedStatement ps = con.prepareStatement(REMOVE_DATA);
            ps.setInt(1, id);
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
     public boolean UpdateData(OrderDetail orde)
    {
        boolean check = false;
        try{
            getConnect();
            PreparedStatement ps = con.prepareStatement(UPDATE_DATA);
            //
           
            ps.setString(1, orde.getDate());
            ps.setInt(2, orde.getUserID());
            ps.setInt(3, orde.getProductID());
            ps.setInt(4, orde.getQuantity());
            ps.setInt(5, orde.getPrice());
            ps.setString(6, orde.getPayment_method());
            ps.setInt(7, orde.getOrderID());
            ps.setInt(8, orde.getOrderDetailId());
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
    public ArrayList<OrderDetail> getPayment(int id)
    {
        ArrayList<OrderDetail> objs = new ArrayList<>();
        try {
           getConnect();
            PreparedStatement ps = con.prepareStatement(GET_DATA_PAYMENT);
            ps.setInt(1, id);
            ResultSet rs = ps.executeQuery();
            if(rs!= null && rs.next())
            {
                OrderDetail item = new OrderDetail();
                item.setOrderDetailId(rs.getInt("OrderDetailID"));
                item.setPayment_method(rs.getString("Payment_method"));
                objs.add(item);
            }
            getClose();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return objs;
    }
    
}
