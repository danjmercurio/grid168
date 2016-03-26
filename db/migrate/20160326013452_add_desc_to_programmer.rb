class AddDescToProgrammer < ActiveRecord::Migration
  def change
    add_column :programmers, :desc, :text
  end
end
