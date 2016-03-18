class FixOutletType < ActiveRecord::Migration
  def change
    remove_column :outlets, :outlet_type
    add_column :outlets, :outlet_type_id, :integer
  end
end
