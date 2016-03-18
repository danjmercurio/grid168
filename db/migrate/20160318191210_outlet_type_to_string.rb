class OutletTypeToString < ActiveRecord::Migration
  def change
    def self.up
      change_column :outlets, :outlet_type, :string
    end
  end
end
