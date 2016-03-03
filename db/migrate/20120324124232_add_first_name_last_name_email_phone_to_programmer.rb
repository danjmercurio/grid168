class AddFirstNameLastNameEmailPhoneToProgrammer < ActiveRecord::Migration
  def change
    add_column :programmers, :first_name, :string
    add_column :programmers, :last_name, :string
    add_column :programmers, :email, :string
    add_column :programmers, :phone, :string
  end
end
