class ChangeOutletTypeToInt < ActiveRecord::Migration
  def self.up
    change_column :outlets, :outlet_type, :integer
  end

  def self.down
    change_column :outlets, :outlet_type, :string
  end
end
