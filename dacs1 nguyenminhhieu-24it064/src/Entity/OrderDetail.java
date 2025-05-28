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
public class OrderDetail {
    private int OrderDetailId;
    private String Date;
    private int UserID;
    private int ProductID;
    private int Quantity;
    private int Price;
    private String Payment_method;
    private int OrderID;

    public int getOrderDetailId() {
        return OrderDetailId;
    }

    public String getDate() {
        return Date;
    }

    public int getUserID() {
        return UserID;
    }

    public int getProductID() {
        return ProductID;
    }

    public int getQuantity() {
        return Quantity;
    }

    public int getPrice() {
        return Price;
    }

    public String getPayment_method() {
        return Payment_method;
    }

    public int getOrderID() {
        return OrderID;
    }

    public void setOrderDetailId(int OrderDetailId) {
        this.OrderDetailId = OrderDetailId;
    }

    public void setDate(String Date) {
        this.Date = Date;
    }

    public void setUserID(int UserID) {
        this.UserID = UserID;
    }

    public void setProductID(int ProductID) {
        this.ProductID = ProductID;
    }

    public void setQuantity(int Quantity) {
        this.Quantity = Quantity;
    }

    public void setPrice(int Price) {
        this.Price = Price;
    }

    public void setPayment_method(String Payment_method) {
        this.Payment_method = Payment_method;
    }

    public void setOrderID(int OrderID) {
        this.OrderID = OrderID;
    }
    
}
