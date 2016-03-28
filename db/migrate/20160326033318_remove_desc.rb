class RemoveDesc < ActiveRecord::Migration
  def change
    remove_column :programmers, :desc
  end
end
