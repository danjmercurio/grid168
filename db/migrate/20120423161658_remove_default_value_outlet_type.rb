class RemoveDefaultValueOutletType < ActiveRecord::Migration
  def up
  	change_column :outlets, :outlet_type, :integer, :null => false
  end

  def down
  	change_column :outlets, :outlet_type, :integer, :default => 0, :null => false
  end
end
