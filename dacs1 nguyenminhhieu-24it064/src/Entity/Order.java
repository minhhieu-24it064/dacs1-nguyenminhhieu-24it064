/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Entity;

/**
 *
 * @author Aki
 */
public class Order {
    private int OrderID;
    private  String Date;
    private String Name;
   private int UserID;
    private int Price;

    public int getOrderID() {
        return OrderID;
    }

    public String getDate() {
        return Date;
    }

    public String getName() {
        return Name;
    }

    public int getUserID() {
        return UserID;
    }

    public int getPrice() {
        return Price;
    }

    public void setOrderID(int OrderID) {
        this.OrderID = OrderID;
    }

    public void setDate(String Date) {
        this.Date = Date;
    }

    public void setName(String Name) {
        this.Name = Name;
    }

    public void setUserID(int UserID) {
        this.UserID = UserID;
    }

    public void setPrice(int Price) {
        this.Price = Price;
    }

    
}
