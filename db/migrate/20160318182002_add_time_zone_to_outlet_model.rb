class AddTimeZoneToOutletModel < ActiveRecord::Migration
  def self.up
    add_column :outlets, :time_zone, :string
  end

  def self.down
    remove_column :outlets, :time_zone
  end
end
