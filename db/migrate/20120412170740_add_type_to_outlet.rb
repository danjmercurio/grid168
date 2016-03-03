class AddTypeToOutlet < ActiveRecord::Migration
  def change
    add_column :outlets, :outlet_type, :integer, :null => false, :default => 0
  end
end
