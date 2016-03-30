class RemoveOldColumns < ActiveRecord::Migration
  def change
    remove_column :offers, :half_hour_clicked
  end
end
