class RemoveFirstNameAndLastNameFromSubChannel < ActiveRecord::Migration
  def up
  	remove_column :sub_channels, :first_name
  	remove_column :sub_channels, :last_name
  end

  def down
  end
end
